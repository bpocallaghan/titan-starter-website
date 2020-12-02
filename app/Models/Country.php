<?php

namespace App\Models;

use Bpocallaghan\Sluggable\HasSlug;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Country
 * @mixin \Eloquent
 */
class Country extends AdminModel
{
    use SoftDeletes, HasSlug;

    protected $table = 'countries';

    protected $guarded = ['id'];

    /**
     * Validation rules for this model
     */
    static public $rules = [
        'name'         => 'required|min:3|max:191',
        'zoom_level'   => 'nullable',
        'latitude'     => 'nullable',
        'longitude'    => 'nullable',
        'continent_id' => 'required|exists:continents,id',
    ];

    /**
     * Get the continent
     */
    public function continent()
    {
        return $this->belongsTo(Continent::class);
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
