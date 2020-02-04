<?php

namespace App\Models;

use App\Models\Traits\ModifyBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Document
 * @mixin \Eloquent
 */
class Document extends Model
{
    use SoftDeletes, ModifyBy;

    protected $table = 'documents';

    protected $guarded = ['id'];

    public $appends = ["url"];

    /**
     * Validation rules for this model
     */
    static public $rules = [
        'file' => 'required|file|max:5000|mimes:pdf'
    ];

    public function getUrlAttribute()
    {
        //return "/uploads/documents/{$this->filename}";
        // for summernote - 'full' url
        return url("/uploads/documents/{$this->filename}");
    }

    public function documentable()
    {
        return $this->morphTo();
    }

    /**
     * Get all the rows as an array (ready for dropdowns)
     *
     * @return array
     */
    public static function getAllList()
    {
    	return self::with('documentable')->orderBy('name')->get()->pluck('name', 'id')->toArray();
    }
}
