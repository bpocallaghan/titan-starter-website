<?php

namespace App\Models\Traits;

use App\Models\FeedbackContactUs;

trait Contactable
{
    /**
     * Get the first section
     * @return mixed
     */
    public function getContactAttribute()
    {
        return $this->contacts()->first();
    }

    /**
     * Get all of the sections.
     */
    public function contacts()
    {
        return $this->morphMany(FeedbackContactUs::class, 'contactable');
    }
}
