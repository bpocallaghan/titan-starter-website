<?php

namespace App\Models;

use Bpocallaghan\Sluggable\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductStatus
 * @mixin \Eloquent
 */
class ProductStatus extends AdminModel
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $table = 'product_statuses';

    protected $guarded = ['id'];

    /**
     * Validation rules for this model
     */
    static public $rules = [
    	'name' => 'required|min:3|max:191',
    	'category' => 'required|min:3|max:191',
    ];

    public function getBadgeAttribute()
    {
        return "<span class='badge badge-{$this->category}'>{$this->name}</span>";
    }

    /**
     * Get all the rows as an array (ready for dropdowns)
     *
     * @return array
     */
    public static function getAllList()
    {
    	return self::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }
}
