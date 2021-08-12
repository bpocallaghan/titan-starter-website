<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Article;
use App\Models\Product;
use App\Models\Document;
use App\Models\ArticleCategory;
use App\Models\ProductFeature;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        // include the documents for the summernote modal
        View::composer('admin.partials.summernote.document', function ($view) {
            $items = Document::with('documentable')
                ->orderBy('name')
                ->get()
                ->pluck('name', 'url')
                ->toArray();

            $view->with('documents', $items);
        });

        // Using Closure based composers...
        View::composer('website.partials.side_articles', function ($view) {

            $categories = ArticleCategory::all();

            $items = Article::whereHas('photos')
                ->where('active_from', '>', Carbon::now()->subDays(30))
                ->orderBy('active_from', 'DESC')
                ->get()
                ->take(5);

            $view->with('articles', $items)
                ->with('categories', $categories);
        });

        // Using Closure based composers...
        View::composer('website.shop.shop_side', function ($view) {

            $features = ProductFeature::getAllList(true);
            $filterCategories = ProductCategory::getMainList(true);

            $items = Product::whereHas('photos')
                ->where('created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('created_at', 'DESC')
                ->get()
                ->take(5);

            $view->with('newItems', $items)
                ->with('filterFeatures', $features)
                ->with('filterCategories', $filterCategories);
        });
    }
}
