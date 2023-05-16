<?php

namespace App\Models;

use App\Models\Traits\ActiveTrait;
use App\Models\Traits\Documentable;
use App\Models\Traits\Photoable;
use App\Models\Traits\Videoable;
use App\Models\Traits\Commentable;
use App\Models\Traits\Sectionable;
use App\Models\Traits\Contactable;
use Bpocallaghan\Sluggable\HasSlug;
use Bpocallaghan\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Article
 * @mixin \Eloquent
 */
class Article extends AdminModel
{
    use SoftDeletes, HasSlug, ActiveTrait, Photoable, Documentable, Videoable, Commentable, Sectionable, Contactable;

    protected $table = 'articles';

    protected $guarded = ['id'];

    protected $casts = [
        'active_from' => 'datetime',
        'active_to' => 'datetime'
    ];

    public static $LARGE_SIZE = [920, 400];

    public static $THUMB_SIZE = [460, 200];

    /**
     * Validation rules for this model
     */
    static public $rules = [
        'name'          => 'required|min:3|max:191',
        'content'       => 'required|min:5|max:5000',
        'summary'       => 'nullable|min:5|max:191',
        'category_id'   => 'required|exists:article_categories,id',
        'active_from'   => 'nullable|date',
        'active_to'     => 'nullable|date',
        'action_name'   => 'nullable|max:191',
        'action_url'    => 'nullable|max:191',
        'allow_comments'=> 'nullable|in:0,on',
    ];

    /**
     * Get the summary text
     *
     * @return mixed
     */
    public function getSummaryAttribute()
    {
        if ($this->attributes['summary']) {
            return $this->attributes['summary'];
        }

        return substr(strip_tags($this->attributes['content']), 0, 120);
    }

    /**
     * Get the createdBy
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Get the category
     */
    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id', 'id');
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
