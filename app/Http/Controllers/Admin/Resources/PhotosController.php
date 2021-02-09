<?php

namespace App\Http\Controllers\Admin\Resources;

use App\Models\Photo;
use Illuminate\Http\UploadedFile;
use App\Models\Traits\ImageThumb;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Admin\AdminController;

class PhotosController extends AdminController
{
    /**
     * Display a listing of photo.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        save_resource_url();

        $items = Photo::with('photoable')->get();

        return $this->view('resources.photos.index')->with('items', $items);
    }

    /**
     * Upload a new photo to the album
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadPhotos()
    {
        // upload the photo here
        $attributes = request()->validate(Photo::$rules);

        // get the photoable
        $photoable = input('photoable_type')::find(input('photoable_id'));

        if (!$photoable) {
            return json_response_error('Whoops', 'We could not find the photoable.');
        }

        // move and create the photo
        $photo = $this->moveAndCreatePhoto($attributes['file'], $photoable);

        if (!$photo) {
            return json_response_error('Whoops', 'Something went wrong, please try again.');
        }

        return json_response(['id' => $photo->id]);
    }

    /**
     * Attach / duplicate a new photo to the item
     * @return \Illuminate\Http\JsonResponse
     */
    public function attach()
    {

        $photoable = request()->photoable_type::find(request()->photoable_id);

        if (!$photoable) {
            return json_response_error('Whoops', 'We could not find the photoable.');
        }

        // move and create the photo
        $existing_photo = photo::find(request()->id);

        $photo = photo::create([
            'filename'          => $existing_photo->filename,
            'photoable_id'   => $photoable->id,
            'photoable_type' => get_class($photoable),
            'name'              =>  (request()->name && request()->name != ''? request()->name: $existing_photo->name),
        ]);

        if (!$photo) {
            return json_response_error('Whoops', 'Something went wrong, please try again.');
        }

        return json_response($photo);
    }

    /**
     * Update the photo's name
     * @param Photo $photo
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePhotoName(Photo $photo)
    {
        $photo->update(['name' => input('name')]);

        return json_response();
    }

    /**
     * Update the album's cover image
     * @param Photo $photo
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePhotoCover(Photo $photo)
    {
        // get the photoable
        //$photoable = input('photoable_type_name')::find(input('photoable_id'));

        // set all the albums to cover = false
        Photo::where('photoable_id', input('photoable_id'))
            ->where('photoable_type', input('photoable_type'))
            ->update(['is_cover' => false]);

        // update this photo to is_cover
        $photo->update(['is_cover' => true]);

        return json_response();
    }

    /**
     * Remove the specified photo from storage.
     *
     * @param Photo $photo
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Photo $photo)
    {
        $this->deleteEntry($photo, request());

        log_activity('Photo Deleted', 'A Photo was successfully deleted', $photo);

        return redirect_to_resource();
    }

    /**
     * Save Image in Storage, crop image and save in public/uploads/images
     * @param UploadedFile $file
     * @param              $photoable
     * @param array        $size
     * @return PhotosController|bool|\Illuminate\Http\JsonResponse
     */
    private function moveAndCreatePhoto(
        UploadedFile $file,
        $photoable,
        $size = ['l' => [1024, 768], 's' => [320, 240]]
    ) {
        $extension = '.' . $file->extension();

        $name = token();
        $filename = $name . $extension;

        $path = upload_path_images();
        $imageTmp = Image::make($file->getRealPath());

        if (!$imageTmp) {
            return false;
        }

        if (isset($photoable::$LARGE_SIZE)) {
            $largeSize = $photoable::$LARGE_SIZE;
            $thumbSize = $photoable::$THUMB_SIZE;
        }
        else {
            $largeSize = $size['l'];
            $thumbSize = $size['s'];
        }

        // save original
        $imageTmp->save($path . $name . Photo::$originalAppend . $extension);

        // if height is the biggest - resize on max height
        if ($imageTmp->width() < $imageTmp->height()) {

            // resize the image to the large height and constrain aspect ratio (auto width)
            $imageTmp->resize(null, $largeSize[1], function ($constraint) {
                $constraint->aspectRatio();
            })->save($path . $filename);

            // resize the image to the thumb height and constrain aspect ratio (auto width)
            $imageTmp->resize(null, $thumbSize[1], function ($constraint) {
                $constraint->aspectRatio();
            })->save($path . $name . ImageThumb::$thumbAppend . $extension);
        }
        else {
            // resize the image to the large width and constrain aspect ratio (auto height)
            $imageTmp->resize($largeSize[0], null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path . $filename);

            // resize the image to the thumb width and constrain aspect ratio (auto width)
            $imageTmp->resize($thumbSize[0], null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path . $name . ImageThumb::$thumbAppend . $extension);
        }

        $originalName = $file->getClientOriginalName();
        $originalName = substr($originalName, 0, strpos($originalName, $extension));
        $name = strlen($originalName) <= 2 ? $photoable->name : $originalName;
        $photo = Photo::create([
            'filename'       => $filename,
            'photoable_id'   => $photoable->id,
            'photoable_type' => get_class($photoable),
            'name'           => strlen($name) < 2 ? 'Photo Name' : $name,
        ]);

        return $photo;
    }
}
