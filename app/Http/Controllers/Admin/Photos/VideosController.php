<?php

namespace App\Http\Controllers\Admin\Photos;

use Image;
use Redirect;
use App\Http\Requests;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Video;
use App\Models\PhotoAlbum;
use App\Http\Controllers\Admin\AdminController;

class VideosController extends AdminController
{
    /**
     * Display a listing of photo.
     *
     * @return Response
     */
    public function index()
    {
        save_resource_url();

        $items = Video::with('photoable')->get();

        return $this->view('photos.videos.index')->with('items', $items);
    }

    /**
     * Store a newly created testimonial in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        if (is_null($request->photo)){
            $attributes = request()->validate(Arr::except(Video::$rules, 'photo'),
                Video::$messages);
        }else {

            $attributes = $this->validate($request, Video::$rules, Video::$messages);

            if (isset($attributes['photo'])){

                $photo = $this->uploadFeaturedImage($attributes['photo']);

                $attributes['image'] = $photo;
                unset($attributes['photo']);
            }
        }

        $attributes['is_cover'] = boolval(input('is_cover'));
        $attributes['is_youtube'] = boolval(input('is_youtube'));

        $video = $this->createEntry(Video::class, $attributes);

        log_activity('Video Created', 'Video was created ' . $video->name);

        if (request()->ajax()) {
            return json_response($video);
        }

        return redirect_to_resource();


    }

    /**
     * Update the specified testimonial in storage.
     * @param Video $video
     * @param Request     $request
     * @return Response
     */
    public function update(Video $video, Request $request)
    {
        if (is_null($request->file('photo'))) {
            $attributes = request()->validate(Arr::except(Video::$rules, 'photo'),
                Video::$messages);
        }
        else {
            $attributes = request()->validate(Video::$rules, Video::$messages);

            if(isset($attributes['photo'])){
                $photo = $this->uploadFeaturedImage($attributes['photo']);
                if ($photo) {
                    $attributes['image'] = $photo;
                }
            }
        }

        $attributes['is_cover'] = boolval(input('is_cover'));
        $attributes['is_youtube'] = boolval(input('is_youtube'));

        unset($attributes['photo']);

        $this->updateEntry($video, $attributes);

        log_activity('Video Updated', 'Video was updated. ' . $video->name);

        if (request()->ajax()) {
            return json_response($video);
        }

        return redirect_to_resource();
    }

    /**
     * Remove the specified testimonial from storage.
     * @param PhotoAlbum $album
     * @param Video $video
     * @param Request     $request
     * @return Response
     */
    public function destroy(PhotoAlbum $album, Video $video, Request $request)
    {
        $this->deleteEntry($video, $request);

        return redirect_to_resource();
    }

    /**
     * Show the form for editing the specified testimonial.
     * @param Video $video
     * @return Response
     */
    public function videoInfo(Video $video)
    {
        return json_response($video);
    }

    /**
     * Update the album's cover image
     * @param Video $video
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateVideoCover(Video $video)
    {
        // get the photoable
        //$photoable = input('photoable_type_name')::find(input('photoable_id'));

        // set all the albums to cover = false
        Video::where('photoable_id', input('photoable_id'))
            ->where('photoable_type', input('photoable_type'))
            ->update(['is_cover' => false]);

        // update this photo to is_cover
        $video->update(['is_cover' => true]);

        return json_response();
    }

    /**
     * Upload the featured image, create a thumb as well
     *
     * @param        $file
     * @param string $path
     * @param array  $size
     * @return string|void
     */
    public function uploadFeaturedImage(
        $file,
        $path = '',
        $size = ['o' => [1024, 576], 'tn' => [400, 226]]
    ) {
        $name = token();
        $extension = $file->guessClientExtension();

        $filename = $name . '.' . $extension;
        $filenameThumb = $name . '-tn.' . $extension;
        $imageTmp = Image::make($file->getRealPath());

        if (!$imageTmp) {
            return notify()->error('Oops', 'Something went wrong', 'warning shake animated');
        }

        $path = upload_path_images($path);

        // save the image
        $image = $imageTmp->fit($size['o'][0], $size['o'][1])->save($path . $filename);

        $image->fit($size['tn'][0], $size['tn'][1])->save($path . $filenameThumb);

        return $filename;
    }
}
