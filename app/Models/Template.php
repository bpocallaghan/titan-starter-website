<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Template
 * @mixin Builder
 */
class Template extends AdminModel
{
    use SoftDeletes;

    protected $table = 'templates';

    protected $guarded = ['id'];

    /**
     * Validation rules for this model
     */
    static public $rules = [
        'name'      => 'required|min:3|max:191',
        'template'  => 'required|min:3|max:191',
        'controller_action'  => 'nullable|min:3|max:191',
    ];

    /**
     * Get all the rows as an array (ready for dropdowns)
     *
     * @return array
     */
    public static function getAllList()
    {
        return self::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    /**
     * Get the layouts
     * @return \Eloquent
     */
    public function layouts()
    {
        return $this->belongsToMany(Layout::class, 'layout_template');
    }
}
