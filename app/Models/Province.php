<?php

namespace App\Models;

use Bpocallaghan\Sluggable\HasSlug;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Province
 * @mixin \Eloquent
 */
class Province extends AdminModel
{
    use SoftDeletes, HasSlug;

    protected $table = 'provinces';

    protected $guarded = ['id'];

    /**
     * Validation rules for this model
     */
    static public $rules = [
        'name'       => 'required|min:3|max:191',
        'country_id' => 'required|exists:countries,id',
    ];

    /**
     * Get the Country
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
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
