<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class LogProductSearch
 * @mixin \Eloquent
 */
class LogProductSearch extends Model
{
    protected $table = 'log_product_searches';

    protected $guarded = ['id'];

    public function setUpdatedAtAttribute($value)
    {
        //
    }

    public static function getLatestSearches()
    {
        return self::orderBy('created_at', 'DESC')->limit(200)->get();
    }
}