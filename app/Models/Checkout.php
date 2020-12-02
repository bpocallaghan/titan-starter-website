<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Checkout
 * @mixin \Eloquent
 */
class Checkout extends AdminModel
{
    use SoftDeletes;

    protected $table = 'checkouts';

    protected $guarded = ['id'];

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
     * Get the transaction
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
