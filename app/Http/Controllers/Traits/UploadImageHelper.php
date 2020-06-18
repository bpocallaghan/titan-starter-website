<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

trait UploadImageHelper
{
    /**
     * Upload the banner image, create a thumb as well
     *
     * @param        $file
     * @param string $path
     * @param array  $size
     * @return string|void
     */
    protected function uploadImage(
        UploadedFile $file,
        $size = ['o' => [1000, 1000], 'tn' => [300, 300]],
        $path = ''
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

        // original
        $imageTmp->save($path . $name . '-o.' . $extension);

        // save the image
        $image = $imageTmp->fit($size['o'][0], $size['o'][1])->save($path . $filename);

        $image->fit($size['tn'][0], $size['tn'][1])->save($path . $filenameThumb);

        return $filename;
    }

    protected function moveImage(UploadedFile $file, $path = '')
    {
        $name = token();
        $extension = $file->guessClientExtension();

        $filename = $name . '.' . $extension;
        $filenameThumb = $name . '-tn.' . $extension;
        $imageTmp = Image::make($file->getRealPath());

        if (!$imageTmp) {
            return notify()->error('Oops', 'Something went wrong', 'warning shake animated');
        }

        $path = upload_path_images($path);

        // original
        $imageTmp->save($path . $name . '-o.' . $extension);
        $imageTmp->save($path . $filename);
        $imageTmp->save($path . $filenameThumb);

        // save the image
        // resize the image to a width of 300 and constrain aspect ratio (auto height)
        //$img->resize(300, null, function ($constraint) {
        //    $constraint->aspectRatio();
        //});

        //$image = $imageTmp->fit($size['o'][0], $size['o'][1])->save($path . $filename);
        //$image->fit($size['tn'][0], $size['tn'][1])->save($path . $filenameThumb);

        return $filename;
    }
}
