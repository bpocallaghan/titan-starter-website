<?php

namespace App\Providers;

use App\Models\NewsCategory;
use Carbon\Carbon;
use App\Models\News;
use App\Models\Product;
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

        // Using Closure based composers...
        View::composer('website.partials.side_news', function ($view) {

            $categories = NewsCategory::all();

            $items = News::whereHas('photos')
                ->where('created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('created_at', 'DESC')
                ->get()
                ->take(5);

            $view->with('news', $items)
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
