<?php

namespace App\Http\Controllers\Admin\Resources;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\ResourceCategory;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Admin\AdminController;

class DocumentsController extends AdminController
{
    /**
     * Display a listing of document.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        save_resource_url();
        $items = Document::with('documentable')->get();

        return $this->view('resources.documents.index')->with('items', $items);
    }

    /**
     * Show the Documentable's documents
     * Create / Edit / Delete the documents
     * @param $documentable
     * @param $documents
     * @return mixed
     */
    private function showDocumentable($documentable, $documents)
    {
        save_resource_url();

        return $this->view('resources.documents.create_edit')
            ->with('documentable', $documentable)
            ->with('documents', $documents);
    }

    /**
     * Show the category's documents
     * @param ResourceCategory $category
     * @return mixed
     */
    public function showCategory(ResourceCategory $category)
    {
        $documents = $category->documents;

        return $this->showDocumentable($category, $documents);
    }

    /**
     * Show the category's documents
     * @param $id
     * @return mixed
     */
    public function showDocuments($id)
    {
        $model = app(session('documentable_type'));
        $model = $model->find($id);

        return $this->showDocumentable($model, $model->documents);
    }

    /**
     * Upload a new document to the item
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload()
    {
        // upload the document here
        $attributes = request()->validate(Document::$rules);

        // get the documentable
        $documentable = input('documentable_type')::find(input('documentable_id'));

        if (!$documentable) {
            return json_response_error('Whoops', 'We could not find the documentable.');
        }

        // move and create the document
        $document = $this->moveAndCreateDocument($attributes['file'], $documentable);

        if (!$document) {
            return json_response_error('Whoops', 'Something went wrong, please try again.');
        }

        return json_response(['id' => $document->id]);
    }

    /**
     * Upload a new document to the album
     * @return \Illuminate\Http\JsonResponse
     */
    public function attach()
    {

        $documentable = request()->documentable_type::find(request()->documentable_id);

        if (!$documentable) {
            return json_response_error('Whoops', 'We could not find the documentable.');
        }

        // move and create the document
        $existing_document = Document::find(request()->id);

        $document = Document::create([
            'filename'          => $existing_document->filename,
            'documentable_id'   => $documentable->id,
            'documentable_type' => get_class($documentable),
            'name'              =>  (request()->name && request()->name != ''? request()->name: $existing_document->name),
            'active_from'       => \Carbon\Carbon::now(),
        ]);

        if (!$document) {
            return json_response_error('Whoops', 'Something went wrong, please try again.');
        }

        return json_response($document);
    }

    /**
     * Update the document's name
     * @param Document $document
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateName(Document $document)
    {
        $document->update(['name' => input('name')]);

        return json_response();
    }

    /**
     * Remove the specified document from storage.
     *
     * @param Document $document
     * @return Response
     */
    public function destroy(Document $document)
    {
        $this->deleteEntry($document, request());

        return redirect_to_resource();
    }

    /**
     * Move document to /uploads/documents
     * @param UploadedFile $file
     * @param              $documentable
     * @return \Illuminate\Http\JsonResponse|static
     */
    private function moveAndCreateDocument(UploadedFile $file, $documentable)
    {
        $name = token();
        $extension = '.' . $file->extension();
        $filename = $name . $extension;

        $file->move(upload_path('documents'), $filename);

        // file not moved
        if (!\File::exists(upload_path('documents') . $filename)) {
            return false;
        }

        $originalName = $file->getClientOriginalName();
        $originalName = substr($originalName, 0, strpos($originalName, $extension));
        $name = strlen($originalName) <= 2 ? $documentable->name : $originalName;
        $document = Document::create([
            'filename'          => $filename,
            'documentable_id'   => $documentable->id,
            'documentable_type' => get_class($documentable),
            'name'              => strlen($name) < 2 ? 'Document Name' : $name,
        ]);

        return $document;
    }
}
