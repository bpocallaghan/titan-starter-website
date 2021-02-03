<?php

namespace App\Models\Traits;

use App\Models\Comment;

trait Commentable
{
    /**
     * Get all of the pages comments.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->where('is_approved', 1);
    }

    /**
     * Scope filter to only allow where has photos
     *
     * @param $query
     * @return mixed
     */
    public function scopeHasComments($query)
    {
        return $query->whereHas('comments');
    }
}
