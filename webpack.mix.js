const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

var publicPath = 'public';
var resourcesPath = 'resources/assets';
var pathJS = resourcesPath + '/js';

var COMPILE = 'all';

if(COMPILE == 'all' || COMPILE == 'js') {
    // update public path for app.js to compile into /resources
    mix.js('resources/assets/js/app.js', 'js/vendor/app_compiled.js');

    mix.scripts([
        'public/js/vendor/app_compiled.js',
        pathJS + '/titan/buttons.js',
        pathJS + '/titan/datatables.js',
        pathJS + '/titan/forms.js',
        pathJS + '/titan/google_maps.js',
        pathJS + '/titan/notifications.js',
        pathJS + '/titan/notify.js',
        pathJS + '/titan/pagination.js',
        pathJS + '/titan/social_media.js',

        pathJS + '/titan/titan.js',
    ], publicPath + '/js/app.js');
}

if(COMPILE == 'all' || COMPILE == 'css') {
    mix.sass('resources/assets/sass/app.scss', 'public/css');
}