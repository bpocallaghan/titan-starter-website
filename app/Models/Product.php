<?php

namespace App\Models;

use App\Models\Traits\Documentable;
use App\Models\Traits\Photoable;
use App\Models\Traits\Videoable;
use Bpocallaghan\Sluggable\HasSlug;
use Bpocallaghan\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 * @mixin \Eloquent
 */
class Product extends AdminModel
{
    use HasFactory, SoftDeletes, HasSlug, Photoable, Documentable, Videoable;

    protected $table = 'products';

    protected $guarded = ['id'];

    protected $casts = [
        'special_from' => 'datetime',
        'special_to' => 'datetime'
    ];

    public static $IMAGE_BACKGROUND = true;

    public static $LARGE_SIZE = [1600, 1600];

    public static $THUMB_SIZE = [300, 300];

    /**
     * Validation rules for this model
     */
    static public $rules = [
        'name'         => 'required|min:3|max:191',
        'reference'    => 'nullable|max:191',
        'amount'       => 'required|numeric',
        'special_amount'=> 'nullable|numeric',
        'in_stock'     => 'nullable',
        'content'      => 'required',
        'category_id'  => 'required|exists:product_categories,id',
        'features'     => 'required|array',
        'special_from' => 'nullable|date',
        'special_to'   => 'nullable|date',
    ];

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
     * Get the Category
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }


    /**
     * Get Category with his Parent
     * @return string
     */
    public function getCategoryAndParentAttribute()
    {
        if ($this->category) {
            if ($this->category->parent) {
                return $this->category->name . " ({$this->category->parent->name})";
            }

            return $this->category->name;
        }

        return '';
    }

    /**
     * Get Name and category
     * @return string
     */
    public function getNameAndCategoryAttribute()
    {
        $name = $this->name;
        if ($this->category) {
            $name .= " {$this->category->name}";
        }

        return $name;
    }

    /**
     * Lazy load relationships
     * @param $query
     * @return mixed
     */
    public function scopeWithAll($query)
    {
        $query->with('photos');
        $query->with('features');
        $query->with('category');

        return $query;
    }

    /**
     * Filter on active (must have photos)
     * @param $query
     * @return mixed
     */
    public function scopeIsActive($query)
    {
        $query->whereHas('photos');

        return $query;
    }

    /**
     * Get the Checkout many to many
     */
    public function checkouts()
    {
        return $this->belongsToMany(Checkout::class);
    }

    /**
     * Get the Transaction many to many
     */
    public function transactions()
    {
        return $this->belongsToMany(Transaction::class);
    }

    /**
     * Get the ProductCondition many to many
     */
    public function features()
    {
        return $this->belongsToMany(ProductFeature::class, 'product_feature_pivot');
    }

    protected function getSlugOptions()
    {
        return SlugOptions::create()->generateSlugFrom('name_and_category');
    }
}
