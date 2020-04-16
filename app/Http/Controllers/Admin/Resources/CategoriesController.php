<?php

namespace App\Http\Controllers\Admin\Resources;

use App\Models\ResourceCategory;
use App\Http\Controllers\Admin\AdminController;

class CategoriesController extends AdminController
{
    /**
     * Display a listing of document_category.
     *
     * @return Response
     */
    public function index()
    {
        save_resource_url();

        return $this->view('resources.categories.index')->with('items', ResourceCategory::all());
    }

    /**
     * Show the form for creating a new document_category.
     *
     * @return Response
     */
    public function create()
    {
        return $this->view('resources.categories.create_edit');
    }

    /**
     * Store a newly created document_category in storage.
     *
     * @return Response
     */
    public function store()
    {
        $attributes = request()->validate(ResourceCategory::$rules, ResourceCategory::$messages);

        $category = $this->createEntry(ResourceCategory::class, $attributes);

        return redirect_to_resource();
    }

    /**
     * Show the form for editing the specified document_category.
     *
     * @param ResourceCategory $category
     * @return Response
     */
    public function edit(ResourceCategory $category)
    {
        return $this->view('resources.categories.create_edit')->with('item', $category);
    }

    /**
     * Update the specified document_category in storage.
     *
     * @param ResourceCategory $category
     * @return Response
     */
    public function update(ResourceCategory $category)
    {
        $attributes = request()->validate(ResourceCategory::$rules, ResourceCategory::$messages);

        $category = $this->updateEntry($category, $attributes);

        return redirect_to_resource();
    }

    /**
     * Remove the specified document_category from storage.
     *
     * @param ResourceCategory $category
     * @return Response
     */
    public function destroy(ResourceCategory $category)
    {
        $this->deleteEntry($category, request());

        return redirect_to_resource();
    }
}
