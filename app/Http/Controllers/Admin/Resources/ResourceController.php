<?php

namespace App\Http\Controllers\Admin\Resources;

use App\Models\Video;
use App\Models\Photo;
use App\Models\Document;
use Illuminate\Http\UploadedFile;
use App\Models\Traits\ImageThumb;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Admin\AdminController;

class ResourceController extends AdminController
{
    /**
     * Show the Photoable's photos
     * Create / Edit / Delete the photos
     * @param $resourceable
     * @return mixed
     */
    private function showResourceable($resourceable)
    {
        save_resource_url();

        return $this->view('resources.create_edit')
            ->with('resource', $resourceable)
            ->with('photos', $resourceable->photos)
            ->with('videos', $resourceable->videos)
            ->with('documents', $resourceable->documents);
    }

    /**
     * Show the News' photos
     * @param $resouceable
     * @param $id
     * @return mixed
     */
    public function showResource($resouceable, $id)
    {
        $model_name = str_replace('-', ' ',ucwords($resouceable));
        $model_name = str_replace(' ', '',ucwords($model_name));

        $resource_type = 'App\Models\\'.$model_name;
        $model = app($resource_type);
        $model = $model->find($id);

        return $this->showResourceable($model);
    }
}
