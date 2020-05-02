<?php

namespace App\Http\Controllers\Traits;

use App\Models\LogProductSearch;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductFeature;
use App\Models\ProductBrand;
use Carbon\Carbon;
use ReflectionClass;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

trait SearchShopHelper
{
    private $slugs;

    private $features;

    private $categories;

    private function initSlugParser($slugs = null)
    {
        // log slugs
        if (!$slugs) {
            return false;
        }

        $this->categories = [];
        $categories = collect();

        $slugs = explode('/', $slugs);
        foreach ($slugs as $k => $slug) {
            if (strlen($slug) > 1) {
                LogProductSearch::create([
                    'slug'       => $slug,
                    'created_by' => user()->id
                ]);
            }
        }

        // remove empty items in array
        $this->slugs = array_filter($slugs, function ($value) {
            return $value !== '';
        });


        // find the slugs to search on
        foreach ($this->slugs as $k => $slug) {

            $features = ProductFeature::where('slug', $slug)->first();
            if ($features) {
                $this->features = $features->id;
            }

            $category = ProductCategory::where('slug', $slug)->first();
            if ($category) {
                $categories->push($category);
            }
        }

        // if categories
        $categoriesIds = [];
        if ($categories->count() > 0) {
            $categories = $categories->pluck('id');

            $ids = [];
            foreach ($categories as $k => $categoryId) {
                $ids[$categoryId] = $this->getCategoriesChildrenIds([$categoryId], [$categoryId]);
            }

            if (count($ids) >= 2) {
                // filter categories
                foreach ($ids as $id => $list) {
                    $found = false;
                    // take the id
                    // search in the ids list
                    // if my id is in list - add it to the 'use list'
                    foreach ($ids as $idd => $listt) {
                        // exlude my list
                        if ($idd != $id) {
                            foreach ($listt as $l => $listItem) {
                                // if my id is in list - found
                                if ($listItem == $id) {
                                    $found = true;
                                }
                            }
                        }
                    }

                    if ($found) {
                        $categoriesIds = $list;
                    }
                }
            }
            else if (count($ids) == 1) {
                $categoriesIds = array_values($ids)[0];
            }

            // we need to find all the 'children' for the category
            // if product is linked to level 3 but level 1 is in slug
            // find those items as well
        }

        $this->updateSessionFilters(null, $this->features, $categoriesIds);
    }

    /**
     * Add the filtered to session
     * @param null $category
     * @param null $features
     * @param null $categories
     */
    private function updateSessionFilters($category = null, $features = null, $categories = null)
    {
        session()->put('shop_filtered', true);
        session()->put('shop_filters_category', $category);
        session()->put('shop_filters_features', $features);
        session()->put('shop_filters_categories', $categories);
    }

    /**
     * Filter Products
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    private function filterProducts()
    {
        // query to get the products
        $builder = Product::withAll()->isActive();

        // if filtered
        if (session('shop_filtered')) {
            if (session('shop_filters_name')) {
                $builder->where('name', 'LIKE', "%" . session('shop_filters_name') . "%");
            }

            if (session('shop_filters_category') && session('shop_filters_category') != 'all') {
                $builder->where('category_id', session('shop_filters_category'));
            }

            if (session('shop_filters_features') && session('shop_filters_features') != 'all') {
                    $builder->whereHas('features', function ($query) {
                        return $query->where('product_features.id',
                            session('shop_filters_features'));
                    });
            }

            if (session('shop_filters_categories') && session('shop_filters_categories') != 'all') {

                $builder->whereIn('category_id', session('shop_filters_categories'));
            }
        }

        $items = $builder->orderBy('name')->get();

        $total = Product::isActive()->count();

        return ['items' => $items, 'total' => $total];
    }

    /**
     * Get the paginator for shop product items
     * @return LengthAwarePaginator
     */
    private function getPaginator()
    {
        $perPage = 15;
        $page = input('page', 1);
        $baseUrl = config('app.url') . '/products';
        $itemsObj = $this->filterProducts();
        $items = $itemsObj['items'];
        $total = $itemsObj['total'];

        // paginator
        $paginator = new LengthAwarePaginator($items->forPage($page, $perPage), count($items),
            $perPage, $page, ['path' => $baseUrl, 'originalEntries' => $total]);

        return $paginator;
    }

    /**
     * Get the top level categories
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[]
     */
    private function getCategories()
    {
        $parents = ProductCategory::with('products')
            ->where('parent_id', 0)
            ->orderBy('list_order')
            ->get();
        $parents = $this->getCategoriesChildren($parents);

        return $parents;
    }

    /**
     * Get the category children recursive
     * @param $parents
     * @return \Illuminate\Support\Collection
     */
    private function getCategoriesChildren($parents)
    {
        $items = collect();
        $activeCategory = $this->activeCategory;
        foreach ($parents as $k => $parent) {

            // set total
            $parent->total = $parent->products->count();
            $parent->class = ($activeCategory && $activeCategory->id == $parent->id ? 'current' : '');

            // get all children for this parent
            $rows = ProductCategory::with('products')
                ->where('parent_id', $parent['id'])
                ->orderBy('list_order')
                ->get();

            // if found
            if ($rows->count() > 0) {
                // recursive get the children for the 'new parents'
                $children = $this->getCategoriesChildren($rows);
                if ($children) {

                    foreach ($children as $i => $child) {
                        $child->class = ($activeCategory && $activeCategory->id == $child->id ? 'current' : '');
                    }

                    $parent->total = $children->sum('total');
                    $parent->class = '';
                    $parent->childrenn = $children;
                }
            }

            $items->push($parent);
        }

        return $items;
    }

    /**
     * Get all the categories
     * @param $parentsList
     * @param $parents
     * @return mixed
     */
    private function getCategoriesChildrenIds($parentsList, $parents)
    {

        $newParentList = $parentsList;
        foreach ($parents as $k => $parent) {

            // get all children for this parent
            $rows = ProductCategory::where('parent_id', $parent)->get();

            // if found
            if ($rows->count() > 0) {

                $rows = $rows->pluck('id');
                $parentsList = array_merge($parentsList, $rows->toArray());

                // recursive get the children for the 'new parents'
                $newParentList = $this->getCategoriesChildrenIds($parentsList, $rows);

            }
        }

        return $newParentList;
    }

    /**
     * Get the category children recursive
     * @param $category
     * @param $features
     * @return mixed
     */
    private function getFilterUrl($category = null, $features = null)
    {
        $url = config('app.url').'/products';

        $category = ProductCategory::find($category);
        if ($category) {
            $url .= '/'.$category->slug;
        }

        $features = ProductFeature::find($features);
        if ($features) {
            $url .= '/'.$features->slug;
        }

        return $url;

    }
}
