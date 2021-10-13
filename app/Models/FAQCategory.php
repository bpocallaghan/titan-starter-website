<?php

namespace App\Models;

use Bpocallaghan\Sluggable\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Client
 * @mixin Builder
 */
class FAQCategory extends AdminModel
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $table = 'faq_categories';

    protected $guarded = ['id'];

    /**
     * Validation rules for this model
     */
    static public $rules = [
        'name' => 'required|min:3|max:191',
    ];

    /**
     * Get the faqs
     */
    public function faqs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(FAQ::class, 'category_id')->orderBy('list_order');
    }

    /**
     * Get all the rows as an array (ready for dropdowns)
     * @return array
     */
    public static function getAllList(): array
    {
        return (new self)->orderBy('name')->get()->pluck('name', 'id')->toArray();
    }
}
