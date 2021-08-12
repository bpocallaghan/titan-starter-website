<?php

namespace App\Http\Controllers\Admin\Resources;

use App\Models\Document;
use Illuminate\Http\Request;
use Bpocallaghan\Titan\Http\Requests;
use App\Http\Controllers\Admin\AdminController;

class DocumentsOrderController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $items = Document::orderBy('list_order')->get();

        return $this->view('resources.documents.order')->with('items', $items);
    }

    /**
     * Show the Documentable's documents
     * Create / Edit / Delete the documents
     * @param $documentable
     * @return mixed
     */
    private function showDocumentable($documentable)
    {
        save_resource_url();


        return $this->view('resources.documents.order')
            ->with('documentable', $documentable);

    }

    /**
     * Show the resourceable documents
     * @param $resouceable
     * @param $id
     * @return mixed
     */
    public function showDocuments($resouceable, $id)
    {
        $model_name = str_replace('-', ' ',ucwords($resouceable));
        $model_name = str_replace(' ', '',ucwords($model_name));

        $resource_type = 'App\Models\\'.$model_name;
        $model = app($resource_type);
        $model = $model->find($id);

        return $this->showDocumentable($model);
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
            $document = Document::find($item['id'])->update(['list_order' => ($key + 1)]);
        }

        return ['result' => 'success'];
    }
}
