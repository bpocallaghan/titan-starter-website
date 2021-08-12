<?php

namespace App\Http\Controllers\Website;

use App\Models\Article;
use App\Models\Page;
use App\Models\ProductCategory;

class HomeController extends WebsiteController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->showPageBanner = true;

        $articles = Article::whereHas('photos')->with('photos')->isActiveDates()->orderBy('active_from', 'DESC')->get();

        return $this->view('home')
            ->with('articles', $articles);
    }
}
