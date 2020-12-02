<?php

namespace App\Http\Controllers\Website\Shop;

use App\Models\Product;
use App\Models\Role;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Monolog\Logger;
use App\Http\Requests;
use Monolog\Handler\StreamHandler;
use App\Http\Controllers\Website\WebsiteController;
use App\Notifications\Admin\ProductsPurchased as AdminProductsPurchased;
use App\Notifications\Client\ProductsPurchased;

class BasketController extends WebsiteController
{
    use BasketHelper;

    public function index()
    {
        // clear checkout
        session()->forget('basket.user');
        session()->forget('basket.address');
        session()->forget('basket.checkout.items');
        session()->forget('basket.checkout.token');

        // init checkout
        session()->put('basket.status', 'started');

        $items = $this->fetchItemsFromSession();

        return $this->view('shop.basket.index')->with('items', $items);
    }

    /**
     * Start checkout process
     */
    public function submitBasket()
    {
        $inputs = input('quantity');

        $items = [];
        foreach ($inputs as $id => $quantity) {
            $items[] = ['id' => $id, 'quantity' => $quantity];
        }

        // add items to session
        session()->put('basket.checkout.items', $items);
        session()->put('basket.checkout.token', token());

        $checkout = $this->saveCheckout();

        $log = new Logger('checkout');
        $log->pushHandler(new StreamHandler(storage_path() . '/logs/checkouts.log', Logger::INFO));
        $log->info('USER: ' . user()->id . ' TOTAL: R' . $checkout->amount . ' TOKEN: ' . $checkout->token);
        $log->info('PRODUCTS: ' . $checkout->products->implode('id',
                ',') . ' QUANTITY: ' . $checkout->products->implode('pivot.quantity', ','));

        session()->put('basket.status', 'basket');

        return redirect('/products/basket/address');
    }

    /**
     * Show the address
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function showAddress()
    {
        if (!(session('basket.status') == 'basket' || session('basket.status') == 'address')) {
            return redirect('/products/basket');
        }

        $basket = $this->fetchBasketFromSession();

        session()->put('basket.status', 'address');

        // if user has shipping address
        if (user()->shippingAddress) {
            session()->put('basket.address', user()->shippingAddress->toArray());
            session()->put('basket.address.label', user()->shippingAddress->label);
        }

        return $this->view('shop.basket.address')->with('basket', $basket);
    }

    /**
     * On submit address
     */
    public function submitAddress()
    {
        if (!(session('basket.status') == 'address')) {
            return redirect('/products/basket/address');
        }

        $attributes = $this->validate(request(), [
            'address'     => 'required|min:3',
            'city'        => 'required|min:3',
            'province'    => 'nullable',
            'country'     => 'required|min:3',
            'postal_code' => 'nullable',
        ]);

        session()->put('basket.address', $attributes);
        session()->put('basket.address.label', join(', ', $attributes));

        return redirect('/products/basket/checkout');
    }

    /**
     * Show the checkout page
     * @return mixed
     */
    public function showCheckout()
    {
        if (!(session('basket.status') == 'basket' || session('basket.status') == 'address' || session('basket.status') == 'checkout')) {
            return redirect('/products/basket');
        }

        $basket = $this->fetchBasketFromSession();

        session()->put('basket.status', 'checkout');

        //$this->hide3rdPartyJs = true;

        return $this->view('shop.basket.checkout')->with('basket', $basket);
    }

    /**
     * Submit the checkout / transaction
     */
    public function submitCheckout()
    {
        // validate terms
        if (input('terms') != 'on') {
            return redirect()->back()->withInput()->withErrors([
                'terms' => 'Please select the terms and conditions checkbox',
            ]);
        }

        if (!(session('basket.status') == 'checkout')) {
            return redirect('/products/basket');
        }

        // save transaction
        $transaction = $this->saveTransaction();

        // log transaction
        $log = new Logger('transaction');
        $log->pushHandler(new StreamHandler(storage_path() . '/logs/transaction.log',
            Logger::INFO));
        $log->info('USER: ' . user()->id . ' TOTAL: R' . $transaction->amount . ' TOKEN: ' . $transaction->token);
        $log->info('PRODUCTS: ' . $transaction->products->implode('id',
                ',') . ' QUANTITY: ' . $transaction->products->implode('pivot.quantity', ','));

        // notify user
        user()->notify(new ProductsPurchased($transaction));

        // notify admin
        notify_users_by_role(AdminProductsPurchased::class, $transaction, Role::$ADMIN_NOTIFY);

        // clear after purchase
        session()->forget('basket.items');
        session()->forget('basket.total_items');
        session()->put('basket.status', 'purchased');

        session()->put('basket.transaction.id', $transaction->id);

        return redirect('/products/basket/checkout/feedback');
    }

    /**
     * Show the feedback
     */
    public function showCheckoutFeedback()
    {
        if (!(session('basket.status') == 'purchased')) {
            return redirect('/products/basket');
        }

        $id = session('basket.transaction.id', 0);
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return redirect('/products/basket');
        }

        session()->put('basket.status', 'feedback');

        return $this->view('shop.basket.feedback')->with('item', $transaction);
    }

    /**
     * Add a product to the user's basket
     * @param Product $product
     * @param int     $quantity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addProduct(Product $product, $quantity = 1)
    {
        $items = session('basket.items', []);
        $items[$product->id] = [
            'id'       => $product->id,
            'quantity' => intval($quantity)
        ];

        // count how many of same item
        $count = 0;
        foreach($items as $item){
            $count += $item['quantity'];
        }

        $product->increment('total_baskets');
        session()->put('basket.items', $items);
        session()->put('basket.total_items', $count);

        return redirect('/products/basket');
    }

    /**
     * Remove the product from the basket
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function removeProduct(Product $product)
    {
        $items = session('basket.items', []);
        if (isset($items[$product->id])) {
            unset($items[$product->id]);
        }

        // count how many of same item
        $count = 0;
        foreach($items as $item){
            $count += $item['quantity'];
        }

        session()->put('basket.items', $items);
        session()->put('basket.total_items', $count);

        return redirect('/products/basket');
    }
}
