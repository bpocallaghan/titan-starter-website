<?php

namespace App\Http\Controllers\Admin\Resources;

use Image;
use Redirect;
use App\Models\Video;
use App\Models\Photo;
use App\Http\Requests;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Admin\AdminController;

class VideosController extends AdminController
{
    /**
     * Display a listing of video.
     *
     * @return Response
     */
    public function index()
    {
        save_resource_url();

        $items = Video::with('videoable')->get();

        return $this->view('resources.videos.index')->with('items', $items);
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
     * Upload a new video to the album
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadVideos()
    {
        // upload the video here
        $attributes = request()->validate(Video::$rules);

        // get the videoable
        $videoable = input('videoable_type')::find(input('videoable_id'));

        if (!$videoable) {
            return json_response_error('Whoops', 'We could not find the videoable.');
        }

        // move and create the video
        $video = $this->moveAndCreateVideo($attributes['file'], $videoable);

        if (!$video) {
            return json_response_error('Whoops', 'Something went wrong, please try again.');
        }

        return json_response(['id' => $video->id]);
    }

    /**
     * Attach a new video to the item
     * @return \Illuminate\Http\JsonResponse
     */
    public function attach()
    {

        $videoable = request()->videoable_type::find(request()->videoable_id);

        if (!$videoable) {
            return json_response_error('Whoops', 'We could not find the videoable.');
        }

        // move and create the video
        $existing_video = Video::find(request()->id);

        $video = Video::create([
            'filename'          => $existing_video->filename,
            'link'              => $existing_video->link,
            'videoable_id'      => $videoable->id,
            'videoable_type'    => get_class($videoable),
            'name'              =>  (request()->name && request()->name != ''? request()->name: $existing_video->name),
            'content'           => $existing_video->content,
            'is_youtube'        => $existing_video->is_youtube,
        ]);

        if (!$video) {
            return json_response_error('Whoops', 'Something went wrong, please try again.');
        }

        return json_response($video);
    }

    /**
     * Remove the specified testimonial from storage.
     * @param Video $video
     * @param Request     $request
     * @return Response
     */
    public function destroy(Video $video, Request $request)
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

        // set all the albums to cover = false
        Video::where('videoable_id', input('videoable_id'))
            ->where('videoable_type', input('videoable_type'))
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

    /**
     * Save Image in Storage, crop image and save in public/uploads/images
     * @param UploadedFile $file
     * @param              $videoable
     * @param array        $size
     * @return PhotosController|bool|\Illuminate\Http\JsonResponse
     */
    private function moveAndCreateVideo(
        UploadedFile $file,
        $videoable
    ) {
        $extension = '.' . $file->extension();

        $name = token();
        $filename = $name . $extension;

        $path = upload_path_videos();

        $file->move($path, $filename);

        $originalName = $file->getClientOriginalName();
        $originalName = substr($originalName, 0, strpos($originalName, $extension));
        $name = strlen($originalName) <= 2 ? $videoable->name : $originalName;
        $video = Video::create([
            'filename'       => $filename,
            'videoable_id'   => $videoable->id,
            'videoable_type' => get_class($videoable),
            'name'           => strlen($name) < 2 ? 'Video Name' : $name,
        ]);

        return $video;
    }
}
