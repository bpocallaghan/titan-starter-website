<?php

namespace App\Models;

use App\Models\Traits\PageHelper;
use App\Models\Traits\Commentable;
use App\Models\Traits\Sectionable;
use App\Models\Traits\Contactable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Page
 * @mixin \Eloquent
 */
class Page extends AdminModel
{
    use HasFactory, SoftDeletes, PageHelper, Commentable, Sectionable, Contactable/*, HasSlug*/;

    protected $table = 'pages';

    protected $guarded = ['id'];

    /**
     * Validation rules for this model
     *
     * @var array
     */
    static public $rules = [
        'name'          => 'required|min:3|max:191',
        'title'         => 'required|min:3|max:191',
        'description'   => 'required|min:3|max:191',
        'slug'          => 'nullable',
        'url'           => 'nullable',
        'icon'          => 'nullable',
        'is_header'     => 'nullable|in:0,on',
        'header_order'  => 'nullable|integer',
        'is_footer'     => 'nullable|in:0,on',
        'footer_order'  => 'nullable|digits',
        'is_hidden'     => 'nullable|in:0,on',
        'is_featured'   => 'nullable|in:0,on',
        'parent_id'     => 'nullable',
        'url_parent_id' => 'nullable',
        'allow_comments' => 'nullable|in:0,on',
        'template_id'   => 'nullable|exists:templates,id',
        //'banners'       => 'nullable',
        //'parent_id'     => 'nullable|exists:pages,id',
        //'url_parent_id' => 'nullable|exists:pages,id',
    ];

    /**
     * Get a the title + url concatenated
     *
     * @return string
     */
    public function getTitleUrlAttribute()
    {
        return $this->attributes['title'] . ' ( ' . $this->attributes['url'] . ' )';
    }

    /**
     * Get all the rows as an array (ready for dropdowns)
     *
     * @return array
     */
    public static function getAllList()
    {
        return self::orderBy('name')->get()->pluck('title_url', 'id')->toArray();
    }

    /**
     * Get the template
     */
    public function template()
    {
        return $this->belongsTo(Template::class, 'template_id', 'id');
    }


    /**
     * Get the Banner many to many
     */
    public function banners()
    {
        return $this->belongsToMany(Banner::class)->isActiveDates()->orderBy('created_at', 'DESC');
    }
}
