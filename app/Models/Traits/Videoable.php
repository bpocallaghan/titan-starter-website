<?php

namespace App\Models\Traits;

use App\Models\Video;

trait Videoable
{
    /**
     * Get the cover video attribute
     * @return bool
     */
    public function getCoverVideoAttribute()
    {
        $videos = $this->videos;
        if ($videos->count() >= 1) {
            // get the cover video
            $video = $videos->where('is_cover', true)->first();
            if ($video) {
                return $video;
            }

            // no videos marked as cover - return first
            return $videos->first();
        }

        // no videos uploaded yet
        return false;
    }

    /**
     * Scope filter to only allow where has videos
     *
     * @param $query
     * @return mixed
     */
    public function scopeHasCoverVideo($query)
    {
        return $query->whereHas('videos');
    }

    /**
     * Scope filter to only allow where has videos
     *
     * @param $query
     * @return mixed
     */
    public function scopeHasVideos($query)
    {
        return $query->whereHas('videos');
    }

    /**
     * Get all of the item's videos.
     */
    public function videos()
    {
        return $this->morphMany(Video::class, 'videoable');
    }

    /**
     * Get all Videos.
     */
    public function getAllVideosAttribute()
    {
        return Video::getAllList();
    }
}
