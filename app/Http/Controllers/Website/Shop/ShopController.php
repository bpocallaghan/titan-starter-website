<?php

namespace App\Http\Controllers\Website\Shop;

use App\Http\Requests;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductFeature;
use App\Models\LogProductSearch;
use App\Models\ProductCategory;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Website\WebsiteController;
use App\Http\Controllers\Traits\SearchShopHelper;
use Illuminate\View\View;

class ShopController extends WebsiteController
{
    use SearchShopHelper;

    private $activeCategory = false;

    public function index($slugs = null)
    {
        // flush filters if not ajax
        if (!request()->ajax()) {
            session()->forget('shop_filtered');
            session()->forget('shop_filters_name');
            session()->forget('shop_filters_category');
            session()->forget('shop_filters_features');
            session()->forget('shop_filters_categories');
        }

        $pageIndex = input('page', 1);
        if(!is_numeric($pageIndex)) {
            return "<div class='alert alert-error'>Whoops, the page number is not valid.</div>";
        }

        // if pagination ajax
        if (request()->ajax()) {
            // paginator
            $paginator = $this->getPaginator();

            return response()->json(view('website.shop.pagination')
                ->with('paginator', $paginator)
                ->render());
        }

        // init the slug filter and search classes
        $this->initSlugParser($slugs);

        // paginator
        $paginator = $this->getPaginator();

        $sideCategories = $this->getCategories();
        $features = ProductFeature::getAllList(true);
        $filterCategories = ProductCategory::getMainList(true);

        return $this->view('shop.index')
            ->with('paginator', $paginator)
            ->with('filterCategories', $filterCategories)
            ->with('filterFeatures', $features)
            ->with('sideCategories', $sideCategories);
    }

    /**
     * Save filter items
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter()
    {
        $redirect = input('redirect');
        $search = input('search');
        $category = input('category');
        $features = input('features');

        session()->put('shop_filters_name', $search);

        $this->updateSessionFilters($category, $features);

        if(isset($redirect) && $redirect == true){

            $url = $this->getFilterUrl($category, $features);
            return json_response(['redirect' => $url ]);
        }
        return json_response();
    }

    /**
     * Show the selected product
     * @param $productSlug
     * @return View
     */
    public function show($productSlug)
    {
        $item = Product::where('slug', $productSlug)->first();

        if (!$item) {
            return redirect('/products');
        }

        $this->activeCategory = $item->category;

        //$parents = $item->category->getParentsAndYou();
        //$sideCategories = $this->getCategories();

        // add product name to title
        $this->title = $item->name;

        $sameCategoryItems = Product::withAll()
            ->isActive()
            ->where('id', '!=', $item->id)
            ->where('category_id', $item->category_id)
            ->orderBy('name')
            ->get()
            ->take(10);


        $item->increment('total_views');

        return $this->view('shop.show')
            ->with('item', $item)
            ->with('sameCategoryItems', $sameCategoryItems);
    }
}