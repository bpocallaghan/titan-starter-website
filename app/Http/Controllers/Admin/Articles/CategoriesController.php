<?php

namespace App\Http\Controllers\Admin\Articles;

use Redirect;
use App\Http\Requests;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class CategoriesController extends AdminController
{
	/**
	 * Display a listing of article_category.
	 *
	 * @return Response
	 */
	public function index()
	{
		save_resource_url();

		return $this->view('articles.categories.index')->with('items', ArticleCategory::all());
	}

	/**
	 * Show the form for creating a new article_category.
	 *
	 * @return Response
	 */
	public function create()
	{
		return $this->view('articles.categories.create_edit');
	}

	/**
	 * Store a newly created article_category in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$attributes = request()->validate(ArticleCategory::$rules, ArticleCategory::$messages);

        $category = $this->createEntry(ArticleCategory::class, $attributes);

        return redirect_to_resource();
	}

	/**
	 * Display the specified article_category.
	 *
	 * @param ArticleCategory $category
	 * @return Response
	 */
	public function show(ArticleCategory $category)
	{
		return $this->view('articles.categories.show')->with('item', $category);
	}

	/**
	 * Show the form for editing the specified article_category.
	 *
	 * @param ArticleCategory $category
     * @return Response
     */
    public function edit(ArticleCategory $category)
	{
		return $this->view('articles.categories.create_edit')->with('item', $category);
	}

	/**
	 * Update the specified article_category in storage.
	 *
	 * @param ArticleCategory  $category
     * @param Request    $request
     * @return Response
     */
    public function update(ArticleCategory $category, Request $request)
	{
		$attributes = request()->validate(ArticleCategory::$rules, ArticleCategory::$messages);

        $category = $this->updateEntry($category, $attributes);

        return redirect_to_resource();
	}

	/**
	 * Remove the specified article_category from storage.
	 *
	 * @param ArticleCategory  $category
     * @param Request    $request
	 * @return Response
	 */
	public function destroy(ArticleCategory $category, Request $request)
	{
		$this->deleteEntry($category, $request);

        return redirect_to_resource();
	}
}
