<?php

namespace App\Http\Controllers\Admin\Photos;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Page;
use App\Models\Photo;
use Bpocallaghan\Titan\Http\Requests;
use App\Models\Article;
use App\Models\PhotoAlbum;
use App\Models\PageContent;
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

        return $this->view('photos.order')->with('items', $items);
    }

    /**
     * Show the Photoable's photos
     * Create / Edit / Delete the photos
     * @param $photoable
     * @param $photos
     * @return mixed
     */
    private function showPhotoable($photoable, $photos)
    {
        save_resource_url();


        return $this->view('photos.order')
            ->with('videos', $photoable->videos)
            ->with('photoable', $photoable)
            ->with('photos', $photos)
            ->with('items', $photoable->photos);
    }

    /**
     * Show the News' photos
     * @return mixed
     */
    public function showPhotos($id)
    {
        $model = app(session('photoable_type'));
        $model = $model->find($id);

        return $this->showPhotoable($model, $model->photos);
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
