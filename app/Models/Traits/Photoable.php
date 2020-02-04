<?php

namespace App\Models\Traits;

use App\Models\Photo;
use App\Models\Video;

trait Photoable
{
    /**
     * Get the cover photo attribute
     * @return bool
     */
    public function getCoverPhotoAttribute()
    {
        $photos = $this->photos;
        if ($photos->count() >= 1) {
            // get the cover photo
            $photo = $photos->where('is_cover', true)->first();
            if ($photo) {
                return $photo;
            }

            // no photo marked as cover - return first
            return $photos->first();
        }

        // no photos uploaded yet
        return false;
    }

    /**
     * Get the cover photo attribute
     * @return bool
     */
    public function getCoverVideoAttribute()
    {
        $videos = $this->videos;
        if ($videos->count() >= 1) {
            // get the cover photo
            $video = $videos->where('is_cover', true)->first();
            if ($video) {
                return $video;
            }

            // no photo marked as cover - return first
            return $videos->first();
        }

        // no photos uploaded yet
        return false;
    }

    /**
     * Get all of the album's photos.
     */
    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }

    /**
     * Scope filter to only allow where has photos
     *
     * @param $query
     * @return mixed
     */
    public function scopeHasCoverPhoto($query)
    {
        return $query->whereHas('photos');
    }

    /**
     * Scope filter to only allow where has photos
     *
     * @param $query
     * @return mixed
     */
    public function scopeHasPhotos($query)
    {
        return $query->whereHas('photos');
    }

    /**
     * Get all of the album's photos.
     */
    public function videos()
    {
        return $this->morphMany(Video::class, 'videoable');
    }
}
