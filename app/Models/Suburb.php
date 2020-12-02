<?php

namespace App\Models;

use Bpocallaghan\Sluggable\HasSlug;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Suburb
 * @mixin \Eloquent
 */
class Suburb extends AdminModel
{
    use SoftDeletes, HasSlug;

    protected $table = 'suburbs';

    protected $guarded = ['id'];

    /**
     * Validation rules for this model
     */
    static public $rules = [
        'name'    => 'required|min:3|max:191',
        'city_id' => 'required|exists:cities,id',
    ];

    /**
     * Get the city
     */
    public function city()
    {
        return $this->belongsTo(City::class);
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
