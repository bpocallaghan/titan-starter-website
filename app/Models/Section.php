<?php

namespace App\Models;

use App\Models\Traits\Sectionable;
use App\Models\Traits\Photoable;
use App\Models\Traits\Documentable;
use App\Models\Traits\Videoable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Section
 * @mixin \Eloquent
 */
class Section extends AdminModel
{
    use SoftDeletes, Documentable, Photoable, Videoable, Sectionable;

    protected $table = 'sections';

    protected $guarded = ['id'];

    /**
     * Validation rules for this model
     */
    static public $rules = [
        'name'              => 'nullable|min:3|max:191',
        'content'           => 'nullable|min:5|max:5000',
        'sectionable_id'    => 'required',
        'sectionable_type'  => 'required',
        'layout'            => 'nullable',
    ];

    /**
     * Get the summary text
     *
     * @return mixed
     */
    public function getSummaryAttribute()
    {
        return substr(strip_tags($this->attributes['content']), 0, 120);
    }

    /**
     * Get the parent sectionable model (pages or artilce).
     */
    public function sectionable()
    {
        return $this->morphTo();
    }

    /**
     * Get the summary text
     *
     * @return mixed
     */
    public function getTitleAttribute()
    {

        return (strlen($this->attributes['name']) > 50)? substr(strip_tags($this->attributes['name']),0,50).'...' : $this->attributes['name'];
    }

    /**
     * Get the roles
     * @return \Eloquent
     */
    public function components()
    {
        return $this->belongsToMany(Content::class, 'content_section')->withTimestamps();
    }

    /**
     * Get the createdBy
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

}
