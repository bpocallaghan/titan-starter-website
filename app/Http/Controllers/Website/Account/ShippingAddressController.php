<?php

namespace App\Http\Controllers\Website\Account;

use App\Http\Controllers\Website\WebsiteController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ShippingAddressController extends WebsiteController
{
    public function index()
    {
        $item = user()->shippingAddress;

        return $this->view('account.shipping_address')->with('item', $item);
    }

    /**
     * Update the user's profile info
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        $attributes = request()->validate([
            'address'     => 'required|min:3',
            'city'        => 'required|min:3',
            'province'    => 'nullable',
            'country'     => 'required|min:3',
            'postal_code' => 'nullable',
        ]);

        if (user()->shippingAddress) {
            user()->shippingAddress()->update([
                'address'     => $attributes['address'],
                'city'        => $attributes['city'],
                'province'    => $attributes['province'],
                'country'     => $attributes['country'],
                'postal_code' => $attributes['postal_code'],
            ]);
        }
        else {
            user()->shippingAddress()->create([
                'address'     => $attributes['address'],
                'city'        => $attributes['city'],
                'province'    => $attributes['province'],
                'country'     => $attributes['country'],
                'postal_code' => $attributes['postal_code'],
            ]);
        }

        alert()->success('Updated!', "Your delivery address was successfully updated.");

        return redirect('/account');
    }
}