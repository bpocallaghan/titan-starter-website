<?php

namespace App\Models;

use App\Models\Traits\Photoable;
use App\Models\Traits\Documentable;
use App\Models\Traits\ImageThumb;
use App\Models\Traits\Videoable;
use App\Models\Traits\ModifyBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Document
 * @mixin \Eloquent
 */
class Content extends AdminModel
{
    use SoftDeletes, Documentable, Photoable, ImageThumb, Videoable;

    public static $LARGE_SIZE = [1024, 768];

    public static $THUMB_SIZE = [320, 240];

    protected $table = 'content';

    protected $guarded = ['id'];

    public $imageColumn = 'media';

    static $alignments = [
        //'bottom' => 'Bottom',
        //'center' => 'Center',
        'left'  => 'Left',
        'right' => 'Right',
        'top'   => 'Top',
    ];

    /**
     * Validation rules for this model
     */
    static public $rules = [
        'heading'         => 'nullable|min:3|max:191',
        'heading_element' => 'required|max:2',
        'content'         => 'nullable|max:20000',
        // 'section_id'      => 'required|exists:sections,id',
        'caption'         => 'nullable|max:191',
        'media'           => 'nullable|max:3000|mimes:jpg,jpeg,png,bmp',
        'media_align'     => 'required|max:20',
        'action_name'     => 'nullable|max:191',
        'action_url'      => 'nullable|max:191',
    ];

    /**
     * Get the heading name
     * @return mixed
     */
    public function getNameAttribute()
    {
        if($this->attributes['heading'] != ''){
            return $this->attributes['heading'];
        }else {
            return substr(strip_tags($this->attributes['content']), 0, 50) . '...';
        }

    }

    /**
     * Get the heading name
     * @return mixed
     */
    public function getDropdownNameAttribute()
    {
        if($this->attributes['heading'] != ''){
            return '(#'.$this->attributes['id'].') '.$this->attributes['heading'];
        }else {
            return '(#'.$this->attributes['id'].') '.substr(strip_tags($this->attributes['content']), 0, 50) . '...';
        }

    }

    /**
     * Get the summary text
     *
     * @return mixed
     */
    public function getSummaryAttribute()
    {
        return substr(strip_tags($this->attributes['content']), 0, 120) . '...';
    }

    /**
     * Get the roles
     * @return \Eloquent
     */
    public function sections()
    {
        return $this->belongsToMany(Section::class, 'content_section')->withTimestamps();
    }

    /**
     * Get all the rows as an array (ready for dropdowns)
     *
     * @return array
     */
    public static function getAllList()
    {
    	return self::orderBy('heading')->get()->pluck('dropdownName', 'id')->toArray();
    }
}
