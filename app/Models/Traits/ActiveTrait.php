<?php

namespace App\Models\Traits;

use Carbon\Carbon;

trait ActiveTrait
{
    /**
     * Format the posted date for display
     *
     * @return mixed
     */
    public function getPostedAtAttribute()
    {
        return $this->active_from->format('D, j M Y');
    }

    /**
     * Get the active from carbon instance
     *
     * @return Carbon
     */
    public function getActiveFromAttribute()
    {
        return Carbon::createFromTimestamp(strtotime($this->attributes['active_from']));
    }

    /**
     * If Empty String, dont insert date
     *
     * @param $value
     */
    public function setActiveFromAttribute($value)
    {
        $this->attributes['active_from'] = (strlen($value) > 2 ? $value : Carbon::now());
    }

    /**
     * If Empty String, dont insert date
     *
     * @param $value
     */
    public function setActiveToAttribute($value)
    {
        $this->attributes['active_to'] = (strlen($value) > 2 ? $value : null);
    }

    /**
     * Add filter to only get the active items based on the dates, if they are set
     *
     * @param $query
     * @return mixed
     */
    public function scopeIsActiveDates($query)
    {
        return $query->whereRaw("(active_from IS NULL OR active_from <= '" . Carbon::now() . "')")
            ->whereRaw("(active_to IS NULL OR active_to >= '" . Carbon::now() . "')");
    }

    /**
     * Get the is active date badge
     * @return string
     */
    public function getDateBadgeAttribute()
    {
        $title = 'Not Active';
        $class = 'warning';

        $from = Carbon::parse($this->active_from);
        $to = Carbon::parse($this->active_to);

        // if no active to or if now is between dates
        if (!$this->active_to || now()->lte($to)) {
            if (now()->gte($from)) {
                $title = 'Active';
                $class = 'success';
            }
        }

        // if now is gte active to date - expired
        if ($this->active_to && $to && now()->gte($to)) {
            $title = 'Expired';
            $class = 'danger';
        }

        return "<span class='badge badge-{$class}'>{$title}</span>";
    }
}
