<?php

if (!function_exists('format_date')) {
    /**
     * Format Date
     *
     * @param        $date
     * @param string $format
     * @return bool|string
     */
    function format_date($date, $format = "d F Y")
    {
        return date($format, strtotime($date));
    }
}

if (!function_exists('activitiy_after')) {
    /**
     * Get the After Title of model
     * @param $activity
     * @return string
     */
    function activitiy_after($activity)
    {
        if (strlen($activity->after) > 3) {
            return $activity->after;
        }
        else if (isset($activity->subject->title)) {
            return $activity->subject->title;
        }

        return '';
    }
}
