<?php

namespace App\Http\Controllers\Admin\Resources;

use App\Models\Photo;
use Illuminate\Http\Request;
use Bpocallaghan\Titan\Http\Requests;
use App\Http\Controllers\Admin\AdminController;

class PhotosOrderController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $items = Photo::orderBy('list_order')->get();

        return $this->view('resources.photos.order')->with('items', $items);
    }

    /**
     * Show the Photoable's photos
     * Create / Edit / Delete the photos
     * @param $photoable
     * @return mixed
     */
    private function showPhotoable($photoable)
    {
        save_resource_url();


        return $this->view('resources.photos.order')
            ->with('photoable', $photoable);

    }

    /**
     * Show the resourceables photos
     * @param $resouceable
     * @param $id
     * @return mixed
     */
    public function showPhotos($resouceable, $id)
    {
        $model_name = str_replace('-', ' ',ucwords($resouceable));
        $model_name = str_replace(' ', '',ucwords($model_name));

        $resource_type = 'App\Models\\'.$model_name;
        $model = app($resource_type);
        $model = $model->find($id);

        return $this->showPhotoable($model);
    }

    /**
     * Update the order
     * @param Request $request
     * @return array
     */
    public function update(Request $request)
    {

        $items = json_decode($request->get('list'), true);

        foreach ($items as $key => $item) {
            $photo = Photo::find($item['id'])->update(['list_order' => ($key + 1)]);
        }

        return ['result' => 'success'];
    }
}
