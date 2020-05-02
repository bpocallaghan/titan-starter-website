<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests;
use App\Models\Checkout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;

class CheckoutsController extends AdminController
{
    /**
     * List latest checkouts
     * @return $this
     */
    public function index()
    {
        $items = Checkout::with('user')//->with('transaction')
            ->with('products')->orderBy('created_at')->get()->take(200);

        return $this->view('shop.checkouts.index', compact('items'));
    }

    /**
     * Show Checkout
     * @param Checkout $checkout
     * @return mixed
     */
    public function show(Checkout $checkout)
    {
        return $this->view('shop.checkouts.show')->with('item', $checkout);
    }
}