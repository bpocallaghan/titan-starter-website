<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $appPath = __DIR__ . DIRECTORY_SEPARATOR;
        $path = $appPath . ".." . DIRECTORY_SEPARATOR;
        $path .= "Helpers" . DIRECTORY_SEPARATOR . "*.php";

        foreach (glob($path) as $filename) {
            require_once $filename;
        }
    }
}
