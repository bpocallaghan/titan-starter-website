<?php

namespace App\Http\Controllers\Admin\FAQ;

use App\Models\FAQCategory;
use Illuminate\View\View;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Admin\AdminController;

class CategoriesController extends AdminController
{
	/**
	 * Display a listing of faq_category.
	 *
	 * @return Factory|View
	 */
	public function index()
	{
		save_resource_url();

		return $this->view('faqs.categories.index')->with('items', FAQCategory::all());
	}

	/**
	 * Show the form for creating a new faq_category.
	 *
	 * @return Factory|View
	 */
	public function create()
	{
		return $this->view('faqs.categories.create_edit');
	}

	/**
	 * Store a newly created faq_category in storage.
	 *
	 * @return RedirectResponse|Redirector
	 */
	public function store()
	{
		$attributes = request()->validate(FAQCategory::$rules, FAQCategory::$messages);

        $category = $this->createEntry(FAQCategory::class, $attributes);

        return redirect_to_resource();
	}

	/**
	 * Display the specified faq_category.
	 *
	 * @param FAQCategory $category
	 * @return Factory|View
	 */
	public function show(FAQCategory $category)
	{
		return $this->view('faqs.categories.show')->with('item', $category);
	}

	/**
	 * Show the form for editing the specified faq_category.
	 *
	 * @param FAQCategory $category
     * @return Factory|View
     */
    public function edit(FAQCategory $category)
	{
		return $this->view('faqs.categories.create_edit')->with('item', $category);
	}

	/**
	 * Update the specified faq_category in storage.
	 *
	 * @param FAQCategory $category
     * @return RedirectResponse|Redirector
     */
    public function update(FAQCategory $category)
	{
		$attributes = request()->validate(FAQCategory::$rules, FAQCategory::$messages);

        $category = $this->updateEntry($category, $attributes);

        return redirect_to_resource();
	}

	/**
	 * Remove the specified faq_category from storage.
	 *
	 * @param FAQCategory $category
	 * @return RedirectResponse|Redirector
	 */
	public function destroy(FAQCategory $category)
	{
		$this->deleteEntry($category, request());

        return redirect_to_resource();
	}
}
