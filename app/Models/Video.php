<?php

namespace App\Models;

use App\Models\Traits\ImageThumb;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Photo
 * @mixin \Eloquent
 */
class Video extends AdminModel
{
    use SoftDeletes, ImageThumb;

    protected $table = 'videos';

    protected $guarded = ['id'];

    public static $LARGE_SIZE = [1024, 593];

    public static $THUMB_SIZE = [800, 450];

    static public $rules = [
        'name'           => 'required',
        'link'           => 'required',
        'content'        => 'nullable',
        'photo'          => 'nullable|image|max:6000|mimes:jpg,jpeg,png,bmp',
        'is_cover'       => 'nullable',
        'videoable_id'   => 'required',
        'videoable_type' => 'required',
    ];

    public function videoable()
    {
        return $this->morphTo();
    }
}
