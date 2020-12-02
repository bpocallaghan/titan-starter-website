<?php

namespace App\Models;

use App\Models\Traits\Documentable;
use App\Models\Traits\Photoable;
use App\Models\Traits\Videoable;
use Bpocallaghan\Sluggable\HasSlug;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ResourceCategory
 * @mixin \Eloquent
 */
class ResourceCategory extends AdminModel
{
    use SoftDeletes, HasSlug, Documentable, Photoable, Videoable;

    protected $table = 'resource_categories';

    protected $guarded = ['id'];

    /**
     * Validation rules for this model
     */
    static public $rules = [
        'name' => 'required|min:3|max:191',
    ];

    /**
     * Get all the rows as an array (ready for dropdowns)
     *
     * @return array
     */
    public static function getAllList(): array
    {
    	return self::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }
}
