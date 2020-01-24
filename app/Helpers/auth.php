<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('user')) {
    /**
     * Get the logged in user
     *
     * @param string $guard
     * @return \App\User|\Illuminate\Contracts\Auth\Authenticatable|object
     */
    function user($guard = 'web')
    {
        return (Auth::guard($guard)->user() ?: (object) ['id' => 0]);
    }
}

if (!function_exists('profile_image')) {

    /**
     * Return the path of the logged in user's profile image
     * @return string
     */
    function profile_image()
    {
        if (!auth()->check()) {
            return "/images/logo_small.png";
        }

        $image = user()->image;
        $gender = user()->gender;
        if ($image && strlen($image) > 5) {
            if (is_slug_url($image)) {
                return $image;
            }

            return '/uploads/images/' . $image;
        }

        return "/images/avatars/$gender.png";
    }
}