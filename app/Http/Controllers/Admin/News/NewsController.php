<?php

namespace App\Http\Controllers\Admin\News;

use App\Models\NewsCategory;
use Redirect;
use App\Http\Requests;
use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class NewsController extends AdminController
{
    /**
     * Display a listing of news.
     *
     * @return Response
     */
    public function index()
    {
        save_resource_url();

        $items = News::with(['category', 'photos'])->get();

        return $this->view('news.index', compact('items'));
    }

    /**
     * Show the form for creating a new news.
     *
     * @return Response
     */
    public function create()
    {
        $categories = NewsCategory::getAllList();

        return $this->view('news.create_edit', compact('categories'));
    }

    /**
     * Store a newly created news in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $attributes = request()->validate(News::$rules, News::$messages);

        $article = $this->createEntry(News::class, $attributes);

        return redirect_to_resource();
    }

    /**
     * Display the specified news.
     *
     * @param News $article
     * @return Response
     */
    public function show(News $article)
    {
        return $this->view('news.show')->with('item', $article);
    }

    /**
     * Show the form for editing the specified news.
     *
     * @param News $article
     * @return Response
     */
    public function edit(News $article)
    {
        $categories = NewsCategory::getAllList();

        return $this->view('news.create_edit', compact('categories'))->with('item', $article);
    }

    /**
     * Update the specified news in storage.
     *
     * @param News    $article
     * @param Request $request
     * @return Response
     */
    public function update(News $article, Request $request)
    {
        $attributes = request()->validate(News::$rules, News::$messages);

        $article = $this->updateEntry($article, $attributes);

        return redirect_to_resource();
    }

    /**
     * Remove the specified news from storage.
     *
     * @param News    $article
     * @param Request $request
     * @return Response
     */
    public function destroy(News $article, Request $request)
    {
        $this->deleteEntry($article, $request);

        return redirect_to_resource();
    }
}
