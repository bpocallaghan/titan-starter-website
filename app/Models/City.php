<?php

namespace App\Models;

use Bpocallaghan\Sluggable\HasSlug;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class City
 * @mixin \Eloquent
 */
class City extends AdminModel
{
    use SoftDeletes, HasSlug;

    protected $table = 'cities';

    protected $guarded = ['id'];

    /**
     * Validation rules for this model
     */
    static public $rules = [
        'name'        => 'required|min:3|max:191',
        'province_id' => 'required|exists:provinces,id',
        'zoom_level'  => 'nullable',
        'latitude'    => 'nullable',
        'longitude'   => 'nullable',
    ];

    /**
     * Get the province
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get all the rows as an array (ready for dropdowns)
     *
     * @return array
     */
    public static function getAllLists()
    {
        return self::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }
}
