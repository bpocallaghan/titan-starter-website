<?php

namespace App\Http\Controllers\Admin\Shop;

use Redirect;
use App\Http\Requests;
use App\Models\ProductFeature;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class FeaturesController extends AdminController
{
	/**
	 * Display a listing of product_features.
	 *
	 * @return Response
	 */
	public function index()
	{
		save_resource_url();

		return $this->view('shop.features.index')->with('items', ProductFeature::all());
	}

	/**
	 * Show the form for creating a new product_features.
	 *
	 * @return FeaturesController
	 */
	public function create()
	{
		return $this->view('shop.features.create_edit');
	}

	/**
	 * Store a newly created product_sizes in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$attributes = request()->validate(ProductFeature::$rules, ProductFeature::$messages);

        $feature = $this->createEntry(ProductFeature::class, $attributes);

        return redirect_to_resource();
	}

	/**
	 * Show the form for editing the specified product_features.
	 *
	 * @param ProductFeature $feature
     * @return Response
     */
    public function edit(ProductFeature $feature)
	{
		return $this->view('shop.features.create_edit')->with('item', $feature);
	}

	/**
	 * Update the specified product_sizes in storage.
	 *
	 * @param ProductFeature $feature
     * @return Response
     */
    public function update(ProductFeature $feature)
	{
		$attributes = request()->validate(ProductFeature::$rules, ProductFeature::$messages);

        $feature = $this->updateEntry($feature, $attributes);

        return redirect_to_resource();
	}

	/**
	 * Remove the specified product_sizes from storage.
	 *
	 * @param ProductFeature $feature
	 * @return Response
	 */
	public function destroy(ProductFeature $feature)
	{
		$this->deleteEntry($feature, request());

        return redirect_to_resource();
	}
}
