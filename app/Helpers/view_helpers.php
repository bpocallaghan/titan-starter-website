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

/**
 * Fetch the website settings from session or database
 */
if (!function_exists('settings')) {

    /**
     * @param bool $forceNew
     * @return \Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    function settings($forceNew = false)
    {
        if (!$forceNew) {
            // fetch settings from session
            if (session()->has("titan.settings")) {
                return session("titan.settings");
            }
        }

        // fetch settings or create if not exist
        $settings = \App\Models\Settings::find(1);
        if (is_null($settings)) {
            $settings = \App\Models\Settings::create([
                'name'        => config('app.name'),
                'description' => config('app.description'),
                'author'      => config('app.author'),
                'keywords'    => config('app.keywords'),
            ]);
        }

        session()->put("titan.settings", $settings);

        return $settings;
    }
}
