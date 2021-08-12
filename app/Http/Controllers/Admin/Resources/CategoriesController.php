<?php

namespace App\Http\Controllers\Admin\Resources;

use Illuminate\View\View;
use App\Models\ResourceCategory;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Admin\AdminController;

class CategoriesController extends AdminController
{
    /**
     * Display a listing of resource_category.
     *
     * @return Factory|View
     */
    public function index()
    {
        save_resource_url();

        return $this->view('resources.categories.index')->with('items', ResourceCategory::all());
    }

    /**
     * Show the form for creating a new resource_category.
     *
     * @return Factory|View
     */
    public function create()
    {
        return $this->view('resources.categories.create_edit');
    }

    /**
     * Store a newly created resource_category in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function store()
    {
        $attributes = request()->validate(ResourceCategory::$rules, ResourceCategory::$messages);

        $category = $this->createEntry(ResourceCategory::class, $attributes);

        return redirect_to_resource();
    }

    /**
     * Show the form for editing the specified resource_category.
     *
     * @param ResourceCategory $category
     * @return Factory|View
     */
    public function edit(ResourceCategory $category)
    {
        return $this->view('resources.categories.create_edit')->with('item', $category);
    }

    /**
     * Update the specified resource_category in storage.
     *
     * @param ResourceCategory $category
     * @return RedirectResponse|Redirector
     */
    public function update(ResourceCategory $category)
    {
        $attributes = request()->validate(ResourceCategory::$rules, ResourceCategory::$messages);

        $category = $this->updateEntry($category, $attributes);

        return redirect_to_resource();
    }

    /**
     * Remove the specified resource_category from storage.
     *
     * @param ResourceCategory $category
     * @return RedirectResponse|Redirector
     */
    public function destroy(ResourceCategory $category)
    {
        $this->deleteEntry($category, request());

        return redirect_to_resource();
    }
}
