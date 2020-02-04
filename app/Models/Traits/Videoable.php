<?php

namespace App\Models\Traits;

use App\Models\Video;

trait Videoable
{
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
     * Scope filter to only allow where has photos
     *
     * @param $query
     * @return mixed
     */
    public function scopeHasCoverVideo($query)
    {
        return $query->whereHas('videos');
    }

    /**
     * Scope filter to only allow where has photos
     *
     * @param $query
     * @return mixed
     */
    public function scopeHasVideos($query)
    {
        return $query->whereHas('videos');
    }

    /**
     * Get all of the album's photos.
     */
    public function videos()
    {
        return $this->morphMany(Video::class, 'videoable');
    }
}
