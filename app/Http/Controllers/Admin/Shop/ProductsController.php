<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductFeature;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use App\Http\Controllers\Admin\AdminController;

class ProductsController extends AdminController
{
    /**
     * Display a listing of product.
     *
     * @return Factory|View
     */
    public function index()
    {
        save_resource_url();

        $items = Product::with('category')->get();

        return $this->view('shop.products.index')->with('items', $items);
    }

    /**
     * Show the form for creating a new product.
     *
     * @return Factory|View
     */
    public function create()
    {
        $categories = ProductCategory::getAllList();
        $features = ProductFeature::getAllList();

        return $this->view('shop.products.create_edit')
            ->with('categories', $categories)
            ->with('features', $features);
    }

    /**
     * Store a newly created product in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function store()
    {
        $attributes = request()->validate(Product::$rules, Product::$messages);

        unset($attributes['features']);
        $attributes['in_stock'] = boolval(input('in_stock'));
        $product = $this->createEntry(Product::class, $attributes);

        $product->features()->sync(input('features'));

        return redirect_to_resource();
    }

    /**
     * Display the specified product.
     *
     * @param Product $product
     * @return Factory|View
     */
    public function show(Product $product)
    {
        return $this->view('shop.products.show')->with('item', $product);
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param Product $product
     * @return Factory|View
     */
    public function edit(Product $product)
    {
        save_resource_url();

        $categories = ProductCategory::getAllList();
        $features = ProductFeature::getAllList();

        return $this->view('shop.products.create_edit')
            ->with('item', $product)
            ->with('categories', $categories)
            ->with('features', $features);
    }

    /**
     * Update the specified product in storage.
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(Product $product)
    {
        $attributes = request()->validate(Product::$rules, Product::$messages);

        unset($attributes['features']);
        $attributes['in_stock'] = boolval(input('in_stock'));
        $product = $this->updateEntry($product, $attributes);

        $product->features()->sync(input('features'));

        return redirect()->to("/admin/shop/products");
    }

    /**
     * Remove the specified product from storage.
     *
     * @param Product $product
     * @return RedirectResponse|Redirector
     */
    public function destroy(Product $product)
    {
        $this->deleteEntry($product, request());

        return redirect_to_resource();
    }
}
