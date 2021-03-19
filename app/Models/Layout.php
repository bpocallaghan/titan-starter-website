<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Role
 * @mixin \Eloquent
 */
class Layout extends AdminModel
{
    use SoftDeletes;

    protected $table = 'layouts';

    protected $guarded = ['id'];

    /**
     * Validation rules for this model
     */
    static public $rules = [
        'name'    => 'required|min:3|max:191',
        'slug'    => 'required|min:1|max:191',
        'layout'  => 'required|min:3|max:191',
    ];

    public function getNameSlugAttribute()
    {
        return $this->attributes['name'] . ' (' . $this->attributes['slug'] . ')';
    }

    /**
     * Get all the rows as an array (ready for dropdowns)
     *
     * @return array
     */
    public static function getAllLists($template_id)
    {
        if(isset($template_id)){
            return self::doesnthave('templates')->orWhereTemplate($template_id)->orderBy('name')->get()->pluck('name', 'layout')->toArray();
        }else {
            return self::doesnthave('templates')->orderBy('name')->get()->pluck('name', 'layout')->toArray();
        }

    }

    /**
     * Get the roles
     * @return \Eloquent
     */
    public function templates()
    {
        return $this->belongsToMany(Template::class, 'layout_template')->withTimestamps();
    }

    /**
     * If User is given template type
     * @param string $template
     * @return bool
     */
    public function hasTemplate($template = 0)
    {
        return ($this->templates()->where('id', $template)->first() ? true : false);
    }

    /**
     * Query Scope
     * Get all the users that has the template
     * @param $query
     * @param $template
     * @return mixed
     */
    public function scopeOrWhereTemplate($query, $template)
    {
        return $query->orWhereHas('templates', function ($query) use ($template) {
            return $query->where('template_id', $template);
        });
    }
}
