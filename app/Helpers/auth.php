<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

if (!function_exists('user')) {
    /**
     * Get the logged in user
     *
     * @param string $guard
     * @return \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable|object
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
            return '/images/logo_small.png';
        }

        $image = user()->image;
        if(isset(user()->gender)){
            $default_image = user()->gender;
        }else {
            $default_image = 'default';
        }

        if ($image && strlen($image) > 5) {
            if (is_slug_url($image)) {
                return $image;
            }

            return '/uploads/images/' . $image;
        }

        return '/images/avatars/'.$default_image.'.png';
    }
}

if (!function_exists('token')) {
    /**
     * Generates a random token
     *
     * @param String $str
     *
     * @return String
     */
    function token($str = null)
    {
        $str = $str ?? Str::random();
        $value = str_shuffle(sha1($str . microtime(true)));

        return hash_hmac('sha1', $value, env('APP_KEY'));
    }
}


if (!function_exists('notify_admins')) {
    function notify_admins($class, $argument, $forceEmail = "")
    {
        if (strlen($forceEmail) >= 2) {
            $admins = User::where('email', $forceEmail)->get();
        }
        else {
            $admins = User::whereRole(Role::$ADMIN_NOTIFY)->get();
        }

        if ($admins) {
            foreach ($admins as $a => $admin) {
                $admin->notify(new $class($argument));
            }
        }
    }
}

if (!function_exists('notify_users_by_role')) {
    function notify_users_by_role($class, $argument, $role = "admin")
    {
        $users = User::whereRole($role)->get();
        foreach ($users as $k => $user) {
            $user->notify(new $class($argument));
        }
    }
}
