<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests;
use App\Models\ProductStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class StatusesController extends AdminController
{
	/**
	 * Display a listing of product_status.
	 *
	 * @return $this
	 */
	public function index()
	{
		save_resource_url();

		return $this->view('shop.statuses.index')->with('items', ProductStatus::all());
	}

	/**
	 * Show the form for creating a new product_status.
	 *
	 * @return $this
	 */
	public function create()
	{
		return $this->view('shop.statuses.create_edit');
	}

	/**
	 * Store a newly created product_status in storage.
	 *
	 * @return $this
	 */
	public function store()
	{
		$attributes = request()->validate(ProductStatus::$rules, ProductStatus::$messages);

        $status = $this->createEntry(ProductStatus::class, $attributes);

        return redirect_to_resource();
	}

	/**
	 * Display the specified product_status.
	 *
	 * @param ProductStatus $status
	 * @return $this
	 */
	public function show(ProductStatus $status)
	{
		return $this->view('shop.statuses.show')->with('item', $status);
	}

	/**
	 * Show the form for editing the specified product_status.
	 *
	 * @param ProductStatus $status
     * @return $this
     */
    public function edit(ProductStatus $status)
	{
		return $this->view('shop.statuses.create_edit')->with('item', $status);
	}

	/**
	 * Update the specified product_status in storage.
	 *
	 * @param ProductStatus  $status
     * @return $this
     */
    public function update(ProductStatus $status)
	{
		$attributes = request()->validate(ProductStatus::$rules, ProductStatus::$messages);

        $status = $this->updateEntry($status, $attributes);

        return redirect_to_resource();
	}

	/**
	 * Remove the specified product_status from storage.
	 *
	 * @param ProductStatus  $status
	 * @return $this
	 */
	public function destroy(ProductStatus $status)
	{
		$this->deleteEntry($status, request());

        return redirect_to_resource();
	}
}
