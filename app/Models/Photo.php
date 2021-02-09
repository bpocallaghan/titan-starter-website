<?php

namespace App\Models;

use App\Models\Traits\ModifyBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Photo
 * @mixin \Eloquent
 */
class Photo extends Model
{
    use SoftDeletes, ModifyBy;

    static public $thumbAppend = '-tn';

    static public $originalAppend = '-o';

    protected $table = 'photos';

    protected $guarded = ['id'];

    protected $appends = ['thumb', 'url'/*, 'original_filename', 'original_url'*/];

    static public $rules = [
        'file' => 'required|max:5000|mimes:jpg,jpeg,png,bmp'
    ];

        /**
     * Get all the rows as an array (ready for dropdowns)
     *
     * @return array
     */
    public static function getAllList()
    {
    	return self::with('photoable')->orderBy('name')->get()->pluck('name', 'id')->toArray();
    }


    /**
     * Get the Tag many to many
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function photoable()
    {
        return $this->morphTo();
    }

    /**
     * Get the thumb path (append -tn at the end)
     * @return mixed
     */
    public function getThumbAttribute()
    {
        return $this->appendBeforeExtension(self::$thumbAppend);
    }

    /**
     * Get the thumb path (append -tn at the end)
     * @return mixed
     * original is reserved (original modal data)
     */
    public function getOriginalFilenameAttribute()
    {
        return $this->appendBeforeExtension(self::$originalAppend);
    }

    public function getExtensionAttribute()
    {
        return substr($this->filename, strpos($this->filename, '.'));
    }

    /**
     * Get the url to the photo
     * @return string
     */
    public function getUrlAttribute()
    {
        return $this->urlForName($this->filename);
    }

    public function getThumbUrlAttribute()
    {
        return $this->urlForName($this->thumb);
    }

    public function getOriginalUrlAttribute()
    {
        return $this->urlForName($this->original_filename);
    }

    /**
     * Get the url for the file name (specify thumb, default, original)
     * @param $name
     * @return string
     */
    public function urlForName($name)
    {
        return config('app.url') . '/uploads/images/' . $name;
    }

    /**
     * Apends a string before the extension
     * @param $append
     * @return mixed
     */
    private function appendBeforeExtension($append)
    {
        return substr_replace($this->filename, $append, strpos($this->filename, '.'), 0);
    }
}
