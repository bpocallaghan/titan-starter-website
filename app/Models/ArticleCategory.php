<?php

namespace App\Models;

use Bpocallaghan\Sluggable\HasSlug;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ArticleCategory
 * @mixin \Eloquent
 */
class ArticleCategory extends AdminModel
{
    use SoftDeletes, HasSlug;

    protected $table = 'article_categories';

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
    public static function getAllList()
    {
        return self::orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    /**
     * Get the articles
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id', 'id');
    }
}
