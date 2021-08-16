<?php

namespace App\Http\Controllers\Admin\Resources;

use App\Models\Video;
use Illuminate\Http\Request;
use Bpocallaghan\Titan\Http\Requests;
use App\Http\Controllers\Admin\AdminController;

class VideosOrderController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $items = Video::orderBy('list_order')->get();

        return $this->view('resources.videos.order')->with('items', $items);
    }

    /**
     * Show the Videoable's videos
     * Create / Edit / Delete the videos
     * @param $videoable
     * @return mixed
     */
    private function showVideoable($videoable)
    {
        save_resource_url();

        return $this->view('resources.videos.order')
            ->with('videoable', $videoable);
    }

    /**
     * Show the resourceables videos
     * @param $resouceable
     * @param $id
     * @return mixed
     */
    public function showVideos($resouceable, $id)
    {
        $model_name = str_replace('-', ' ',ucwords($resouceable));
        $model_name = str_replace(' ', '',ucwords($model_name));

        $resource_type = 'App\Models\\'.$model_name;
        $model = app($resource_type);
        $model = $model->find($id);

        return $this->showVideoable($model);
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
            $photo = Video::find($item['id'])->update(['list_order' => ($key + 1)]);
        }

        return ['result' => 'success'];
    }
}
