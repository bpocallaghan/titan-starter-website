<?php

namespace App\Http\Controllers\Website;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Pagination\LengthAwarePaginator;

class NewsController extends WebsiteController
{
    //use GoogleCaptcha;

    public function index($categorySlug = null)
    {
        if (isset($categorySlug)) {
            $category = NewsCategory::where('slug', $categorySlug)->first();
            $items = News::where('category_id', $category->id)->whereHas('photos')->with('photos')->isActiveDates()->orderBy('active_from', 'DESC')->get();
        } else {
            $items = News::whereHas('photos')->with('photos')->isActiveDates()->orderBy('active_from', 'DESC')->get();
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
            return response()->json(view('website.news.pagination')
                ->with('paginator', $paginator)
                ->render());
        }

        return $this->view('news.index')->with('paginator', $paginator);
    }

    /**
     * Show News and Events
     * @param $categorySlug
     * @param $newsSlug
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show($categorySlug, $newsSlug)
    {

        $item = News::with('photos')->where('slug', $newsSlug)->first();

        if (!$item) {
            return redirect('/articles');
        }

        $this->title = $item->name;


        return $this->view('news.show')->with('news', $item);
    }
}
