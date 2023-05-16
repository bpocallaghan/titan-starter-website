<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Traits\ImageThumb;
use App\Models\Traits\ActiveTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Banner
 * @mixin Model
 */
class Banner extends AdminModel
{
    use HasFactory, SoftDeletes, ActiveTrait, ImageThumb;

    protected $table = 'banners';

    protected $guarded = ['id'];

    protected $casts = [
        'active_from' => 'datetime',
        'active_to' => 'datetime'
    ];

    public static $LARGE_SIZE = [1920, 600];

    public static $THUMB_SIZE = [640, 200];

    public static $IMAGE_SIZE = ['o' => [1920, 600], 'tn' => [640, 200]];

    /**
     * Validation rules for this model
     */
    static public $rules = [
        'name'        => 'required|min:3|max:191',
        'description' => 'nullable|max:191',
        'action_name' => 'nullable|max:191',
        'action_url'  => 'nullable|max:191',
        'active_from' => 'nullable|date',
        'active_to'   => 'nullable|date',
        'photo'       => 'required|max:6000|mimes:jpg,jpeg,png,bmp',
    ];

    /**
     * Get all the rows as an array (ready for dropdowns)
     *
     * @return array
     */
    public static function getAllList()
    {
        return self::isActiveDates()->orderBy('name')->get()->pluck('name', 'id')->toArray();
    }

    /**
     * Get the Page many to many
     */
    public function pages()
    {
        return $this->belongsToMany(Page::class);
    }
}
