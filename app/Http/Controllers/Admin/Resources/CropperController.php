<?php

namespace App\Http\Controllers\Admin\Resources;

use Image;
use App\Models\Photo;
use App\Http\Requests;
use App\Http\Controllers\Admin\AdminController;

class CropperController extends AdminController
{
    private $LARGE_SIZE = [1024, 768];

    private $THUMB_SIZE = [320, 240];

    /**
     * @param       $photoable
     * @param Photo $photo
     * @return this
     */
    private function showCropper($photoable, Photo $photo)
    {
        return $this->view('resources.cropper')->with('photoable', $photoable)->with('photo', $photo);
    }

    /**
     * Show the Photoables' photos
     * @return mixed
     */
    public function showPhotos(Photo $photo)
    {
        $model = app($photo->photoable_type);
        $model = $model->find($photo->photoable_id);

        return $this->showCropper($model, $photo);
    }

    /**
     * Crop a photo
     * @param Photo $photo
     * @return \Illuminate\Http\JsonResponse
     */
    public function cropPhoto(Photo $photo)
    {
        $photoable = input('photoable_type')::find(input('photoable_id'));

        // if relationship not found
        if (!$photoable) {
            return json_response_error('Whoops', 'We could not find the photoable.');
        }

        // get the large and thumb sizes
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
        $originalImage = Image::make($photo->original_url);

        // get the crop data
        $x = intval(input('x'));
        $y = intval(input('y'));
        $width = intval(input('width'));
        $height = intval(input('height'));
        $scaleX = intval(input('scaleX'));
        $scaleY = intval(input('scaleY'));
        $rotate = intval(input('rotate'));

        // generate new name (bypass cache)
        $photo->update([
            'filename' => token() . "{$photo->extension}"
        ]);

        // save original image with new name
        $originalImage->save($path . $photo->original_filename);

        // crop image on cropped area
        //$imageTmp = $originalImage->crop($width, $height, $x, $y);

        //ensure the background color is white (if cropping outside the actual image)
        $imageTmp = Image::canvas($width *3 , $height *3);
        $imageTmp->fill('#fff');
        $image11 = Image::make($photo->original_url);

        if($scaleX == -1 && $scaleY == 1){
            // flip image horizontally
            $image11->flip('h');
        } else if($scaleX == 1 && $scaleY == -1){
            // flip image vertically
            $image11->flip('v');
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

            $image11->rotate($num);
        }

        $imageTmp->insert($image11, 'top-left', $width, $height);


        $imageTmp->crop($width, $height, $width+$x, $height+$y);

        // resize the image to large size
        $imageTmp->resize($largeSize[0], null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path . $photo->filename);

        // resize the image to thumb size
        $imageTmp->resize($thumbSize[0], null, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path . $photo->thumb);

        return json_response('success');
    }
}
