<?php

namespace App\Models\Traits;

trait ImageThumb
{
    static public $thumbAppend = '-tn';

    static public $originalAppend = '-o';

    //protected $appends = ['thumb', 'original'];

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
        return substr($this->getImageAttributeName(), strpos($this->getImageAttributeName(), '.'));
    }

    /**
     * Get the thumb path (append -tn at the end)
     * @return mixed
     */
    public function getImageThumbAttribute()
    {
        return $this->appendBeforeExtension(self::$thumbAppend);
    }

    /**
     * Get the thumb path (append -tn at the end)
     * @return mixed
     */
    public function getImageOriginalAttribute()
    {
        return $this->appendBeforeExtension(self::$originalAppend);
    }

    /**
     * Apends a string before the extension
     * @param $append
     * @return mixed
     */
    private function appendBeforeExtension($append)
    {
        return substr_replace($this->getImageAttributeName(), $append,
            strpos($this->getImageAttributeName(), '.'), 0);
    }

    /**
     * Get the url to the photo
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return $this->urlForName($this->getImageAttributeName());
    }

    public function getThumbUrlAttribute()
    {
        return $this->urlForName($this->image_thumb);
    }

    public function getOriginalUrlAttribute()
    {
        return $this->urlForName($this->image_original);
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
     * Get the value for the image
     * @return mixed
     */
    private function getImageAttributeName()
    {
        if (property_exists($this, 'imageColumn')) {
            return $this->{$this->imageColumn};
        }

        return $this->image;
    }
}
