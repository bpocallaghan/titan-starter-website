<?php

namespace App\Http\Controllers\Website;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticlesController extends WebsiteController
{
    //use GoogleCaptcha;

    public function index($categorySlug = null)
    {
        if (isset($categorySlug)) {
            $category = ArticleCategory::where('slug', $categorySlug)->first();
            $items = Article::where('category_id', $category->id)->whereHas('photos')->with('photos')->isActiveDates()->orderBy('active_from', 'DESC')->get();
        } else {
            $items = Article::whereHas('photos')->with('photos')->isActiveDates()->orderBy('active_from', 'DESC')->get();
        }

        $perPage = 6;
        $page = input('page', 1);
        $baseUrl = config('app.url') . '/articles/' . $categorySlug;


        $total = $items->count();

        // paginator
        $paginator = new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            ['path' => $baseUrl, 'originalEntries' => $total]
        );

        // if pagination ajax
        if (request()->ajax()) {
            return response()->json(view('website.articles.pagination')
                ->with('paginator', $paginator)
                ->render());
        }

        return $this->view('articles.index')->with('paginator', $paginator);
    }

    /**
     * Show Article and Events
     * @param $categorySlug
     * @param $articleSlug
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show($categorySlug, $articleSlug)
    {

        $item = Article::with('photos')->where('slug', $articleSlug)->first();

        if (!$item) {
            return redirect('/new');
        }

        $this->title = $item->name;


        return $this->view('articles.show')->with('article', $item);
    }
}
