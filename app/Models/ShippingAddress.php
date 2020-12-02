<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ShippingAddress
 * @mixin \Eloquent
 */
class ShippingAddress extends AdminModel
{
    use SoftDeletes;

    protected $table = 'shipping_addresses';

    protected $guarded = ['id'];

    /**
     * Get the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the Transaction
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function getLabelAttribute()
    {
        $address = $this->attributes['address'];
        if($this->attributes['city']) {
            $address .= ", " . $this->attributes['city'];
        }
        if($this->attributes['province']) {
            $address .= ", " . $this->attributes['province'];
        }
        if($this->attributes['country']) {
            $address .= ", " . $this->attributes['country'];
        }
        return $address;
    }
}
