<?php

namespace App\Http\Controllers\Admin\Resources;

use App\Http\Controllers\Admin\AdminController;

class ResourceController extends AdminController
{
    /**
     * Show the Resource's photos, videos, documents
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
