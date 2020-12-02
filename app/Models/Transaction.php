<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Class Transaction
 * @mixin \Eloquent
 */
class Transaction extends AdminModel
{
    use SoftDeletes;

    protected $table = 'transactions';

    protected $guarded = ['id'];

    public function getOrderNumberAttribute()
    {
        return str_pad($this->id, 5, 0, STR_PAD_LEFT);
    }

    public function createReference()
    {
        $this->reference = $this->getUniqueReference();

        self::save();
    }

    /**
     * Get the unique reference value
     * @return String
     */
    private function getUniqueReference()
    {
        $random = strtoupper(Str::random(3));
        $token = "SHOP-{$random}-{$this->order_number}";
        if (self::where('reference', $token)->first()) {
            return $this->getUniqueReference();
        }

        return $token;
    }

    /**
     * Get the Product many to many
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    /**
     * Get the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the checkout
     */
    public function checkout()
    {
        return $this->belongsTo(Checkout::class);
    }

    /**
     * Get the status
     */
    public function status()
    {
        return $this->belongsTo(ProductStatus::class, 'status_id', 'id');
    }

    /**
     * Get the shippingAddress
     */
    public function shippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class, 'shipping_address_id', 'id');
    }
}
