<?php

namespace App\Models\Traits;

trait UserHelper
{
    /**
     * Get the user fullname (firstname + lastname)
     *
     * @return string
     */
    public function getFullnameAttribute()
    {
        return $this->attributes['firstname'] . ' ' . $this->attributes['lastname'];
    }

    public function getIsEmailVerifiedBadgeAttribute()
    {
        return $this->email_verified_at ? '<span class="badge bg-green">' . $this->email_verified_at->format('d M Y') . '</span>' : '<span class="badge bg-red">not yet</span>';
    }
}