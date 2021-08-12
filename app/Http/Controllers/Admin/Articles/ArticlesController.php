<?php

namespace App\Http\Controllers\Admin\Articles;

use App\Models\ArticleCategory;
use Redirect;
use App\Http\Requests;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class ArticlesController extends AdminController
{
    /**
     * Display a listing of articles.
     *
     * @return Response
     */
    public function index()
    {
        save_resource_url();

        $items = Article::with(['category', 'photos'])->get();

        return $this->view('articles.index', compact('items'));
    }

    /**
     * Show the form for creating a new articles.
     *
     * @return Response
     */
    public function create()
    {
        $categories = ArticleCategory::getAllList();

        return $this->view('articles.create_edit', compact('categories'));
    }

    /**
     * Store a newly created article in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $attributes = request()->validate(Article::$rules, Article::$messages);

        $attributes['allow_comments'] = (bool) input('allow_comments');

        $article = $this->createEntry(Article::class, $attributes);

        return redirect_to_resource();
    }

    /**
     * Display the specified articles.
     *
     * @param Article $article
     * @return Response
     */
    public function show(Article $article)
    {
        return $this->view('articles.show')->with('item', $article);
    }

    /**
     * Show the form for editing the specified articles.
     *
     * @param Article $article
     * @return Response
     */
    public function edit(Article $article)
    {
        $categories = ArticleCategory::getAllList();

        return $this->view('articles.create_edit', compact('categories'))->with('item', $article);
    }

    /**
     * Update the specified article in storage.
     *
     * @param Article    $article
     * @param Request $request
     * @return Response
     */
    public function update(Article $article, Request $request)
    {
        $attributes = request()->validate(Article::$rules, Article::$messages);

        $attributes['allow_comments'] = (bool) input('allow_comments');

        $article = $this->updateEntry($article, $attributes);

        return redirect_to_resource();
    }

    /**
     * Remove the specified article from storage.
     *
     * @param Article    $article
     * @param Request $request
     * @return Response
     */
    public function destroy(Article $article, Request $request)
    {
        $this->deleteEntry($article, $request);

        return redirect_to_resource();
    }
}
