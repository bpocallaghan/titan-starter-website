<?php

namespace App\Models;

use Bpocallaghan\Sluggable\HasSlug;
use Bpocallaghan\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Client
 * @mixin Builder
 */
class FAQ extends AdminModel
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $table = 'faqs';

    protected $guarded = ['id'];

    /**
     * Validation rules for this model
     */
    static public $rules = [
        'question'    => 'required|min:3|max:191',
        'answer'      => 'required|min:5|max:1500',
        'category_id' => 'required|exists:faq_categories,id',
    ];

    protected function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugFrom('question');
    }

    /**
     * Get the summary text
     *
     * @return mixed
     */
    public function getAnswerSummaryAttribute()
    {
        return substr(strip_tags($this->attributes['answer']), 0, 80) . '...';
    }

    /**
     * Get the category
     */
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(FAQCategory::class, 'category_id', 'id');
    }
}
