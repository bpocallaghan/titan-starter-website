<?php

namespace App\Http\Controllers\Website\Shop;

use App\Models\Checkout;
use App\Models\Product;
use App\Models\ShippingAddress;
use App\Models\Transaction;
use Carbon\Carbon;

trait BasketHelper
{
    /**
     * Get checkout - items is in session
     * @return object
     */
    private function fetchBasketFromSession()
    {
        $items = $this->fetchItemsFromSession('checkout.items');
        $totalItems = $items->sum('quantity');
        $total = $items->sum('total');

        // calculate 12% handling fee
        //$handlingFee = $total * 0.12;
        //$subtotal = $total + $handlingFee;
        $subtotal = $total;
        // calculate 15% tax
        $tax = 0; // disabled
        //$tax = $subtotal * 0.15;
        // get grand total
        $grandTotal = $total;// + $tax;

        //dump($total);
        //dump($totalItems);
        //dd($items[1]->toArray());

        $checkout = (object) [
            'amount'          => $grandTotal,
            'amount_original' => $grandTotal,
            'amount_items'    => $total,
            'amount_tax'      => $tax,
            'totalItems'      => $totalItems,
            'items'           => $items,
            'user_id'         => user()->id,
            'token'           => session('basket.checkout.token', token()),
        ];

        return $checkout;
    }

    /**
     * Fetch the products from the session
     * @param string $key
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    private function fetchItemsFromSession($key = 'items')
    {
        $items = session("basket.{$key}", []);
        $itemIds = collect($items)->pluck('id', 'id')->values()->toArray();
        $products = Product::withAll()->isActive()->whereIn('id', $itemIds)->orderBy('name')->get();

        $checkout = $items;
        foreach ($products as $k => $product) {
            foreach ($checkout as $i => $item) {
                if ($item['id'] == $product->id) {
                    $product->quantity = intval($item['quantity']);
                    $product->total = floatval($product->amount * $product->quantity);
                }
            }
        }

        return $products;
    }

    /**
     * Save the checkout items
     */
    private function saveCheckout()
    {
        $basket = $this->fetchBasketFromSession();

        // save checkout
        $checkout = Checkout::create([
            'token'           => $basket->token,
            'amount'          => $basket->amount,
            'amount_items'    => $basket->amount_items,
            'amount_tax'      => $basket->amount_tax,
            'user_id'         => $basket->user_id,
            'amount_original' => $basket->amount_original,
        ]);

        // save products
        foreach ($basket->items as $k => $item) {
            $item->increment('total_checkouts');
            $checkout->products()->attach($item->id, [
                'quantity' => $item->quantity,
            ]);
        }

        return $checkout;
    }

    /**
     * Save the checkout items
     */
    private function saveTransaction()
    {
        $basket = $this->fetchBasketFromSession();

        // save checkout
        $transaction = Transaction::create([
            'token'           => $basket->token,
            'amount'          => $basket->amount,
            'amount_items'    => $basket->amount_items,
            'amount_tax'      => $basket->amount_tax,
            'user_id'         => $basket->user_id,
            'amount_original' => $basket->amount_original,
        ]);
        $transaction->createReference();

        $addressSession = session('basket.address');
        if (user()->shippingAddress) {
            user()->shippingAddress()->update([
                'address'     => $addressSession['address'],
                'city'        => $addressSession['city'],
                'province'    => $addressSession['province'],
                'country'     => $addressSession['country'],
                'postal_code' => $addressSession['postal_code'],
            ]);
        }
        else {
            user()->shippingAddress()->create([
                'address'     => $addressSession['address'],
                'city'        => $addressSession['city'],
                'province'    => $addressSession['province'],
                'country'     => $addressSession['country'],
                'postal_code' => $addressSession['postal_code'],
            ]);
        }

        // save products
        foreach ($basket->items as $k => $item) {
            $item->increment('total_purchases');
            $transaction->products()->attach($item->id, [
                'quantity' => $item->quantity,
            ]);
        }

        $checkout = Checkout::where('token', $basket->token)->first();
        if ($checkout) {
            $checkout->update([
                'transaction_id'        => $transaction->id,
                'linked_transaction_at' => Carbon::now(),
            ]);

            $transaction->update([
                'checkout_id'        => $checkout->id,
                'linked_checkout_at' => Carbon::now(),
                //'shipping_address_id' => $address->id,
            ]);
        }

        return $transaction;
    }
}