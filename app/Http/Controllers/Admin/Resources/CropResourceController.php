<?php

namespace App\Http\Controllers\Admin\Resources;

use Image;
use App\Models\Photo;
use App\Http\Requests;
use Illuminate\Support\Str;
use App\Http\Controllers\Admin\AdminController;

class CropResourceController extends AdminController
{
    private $LARGE_SIZE = [1600, 800];

    private $THUMB_SIZE = [1024, 768];

    /**
     * @param  $photoable
     * @return this
     */
    private function showCropper($photoable)
    {
        return $this->view('resources.crop_resource')->with('photoable', $photoable);
    }

    /**
     * @param $resourceable
     * @param $id
     * @return this
     */
    public function showPhoto($resourceable, $id)
    {
        $resource = Str::plural($resourceable, 1);
        $resourceable = Str::singular($resourceable);

        $model_name = str_replace('-', ' ',ucwords($resourceable));
        $model_name = str_replace(' ', '',ucwords($model_name));

        $resource_type = 'App\Models\\'.$model_name;
        $model = app($resource_type);
        $model = $model->find($id);

        return $this->showCropper($model);
    }

    /**
     * Crop a photo
     * @return \Illuminate\Http\JsonResponse
     */
    public function cropPhoto()
    {
        $photoable = input('photoable_type')::find(input('photoable_id'));

        // if relationship not found
        if (!$photoable) {
            return json_response_error('Whoops', 'We could not find the photoable.');
        }

        // get the large and thumb features
        if (isset($photoable::$LARGE_SIZE)) {
            $largeSize = $photoable::$LARGE_SIZE;
            $thumbSize = $photoable::$THUMB_SIZE;
        }
        else {
            $largeSize = $this->LARGE_SIZE;
            $thumbSize = $this->THUMB_SIZE;
        }

        // open file image resource
        $path = upload_path_images();
        $originalImage = Image::make($photoable->original_url);

        // get the crop data
        $x = intval(input('x'));
        $y = intval(input('y'));
        $width = intval(input('width'));
        $height = intval(input('height'));
        $scaleX = intval(input('scaleX'));
        $scaleY = intval(input('scaleY'));
        $rotate = intval(input('rotate'));

        // generate new name (bypass cache)
        $photoable->update([
            (isset($photoable->imageColumn)? $photoable->imageColumn: 'image')=> token() . "{$photoable->extension}"
        ]);

        // save original image with new name
        $originalImage->save($path . $photoable->original_filename);

        if($scaleX == -1 && $scaleY == 1){
            // flip image horizontally
            $originalImage->flip('h');
        } else if($scaleX == 1 && $scaleY == -1){
            // flip image vertically
            $originalImage->flip('v');
        }

        if($rotate != 0){
            // if number is negative - make positive (cropper js values are invert of what image intervention uses)
            if($rotate < 0 ){
                $num = -1 * (int)$rotate;
            }
            // if number is positive - make negative (cropper js values are invert of what image intervention uses)
            if($rotate > 0){
                $num = - (int)$rotate;
            }

            $originalImage->rotate($num);
        }

        if(isset($photoable->image)){
            $column = 'image';
        }else {
            $column = $photoable->imageColumn;
        }
        $use_file_name = $photoable->$column;

        // crop image on cropped area
        $imageTmp = $originalImage->crop($width, $height, $x, $y);

        // resize the image to large size
        $imageTmp->resize($largeSize[0], null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path . (isset($photoable->image)? $photoable->image: $photoable->imageColumn));

        // resize the image to thumb size
        $imageTmp->resize($thumbSize[0], null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path . $use_file_name);

        return json_response('success');
    }
}
