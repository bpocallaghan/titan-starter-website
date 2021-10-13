<?php

namespace App\Http\Controllers\Admin\Resources;

use Illuminate\Support\Str;
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
     * Show the resourceables resource
     * @param $resourceable1
     * @param $resourceable2
     * @param $id
     * @return mixed
     */
    public function showResource($resourceable1, $resourceable2 = null, $id)
    {
        if (isset($resourceable1)) {
            $resourceable = $resourceable1;
        }
        if (isset($resourceable2) && $resourceable2 !== "0") {
            $resourceable = $resourceable2;
        }

        $resource = Str::plural($resourceable, 1);
        $resourceable = Str::singular($resourceable);

        $model_name = str_replace('-', ' ', ucwords($resourceable));
        $model_name = str_replace(' ', '', ucwords($model_name));

        $resource_type = 'App\Models\\' . $model_name;
        $model = app($resource_type);
        $model = $model->find($id);

        return $this->showResourceable($model);
    }
}
