const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

var publicPath = "public";
var resourcesPath = "resources/assets";
var pathJS = resourcesPath + "/js";

var COMPILE = "all";

// do not extract/save .LICENSE.txt files
mix.options({
    terser: {
        extractComments: false
    }
});

mix.webpackConfig(webpack => {
    return {
        resolve: {
            fallback: {
                stream: require.resolve('stream-browserify'),
                tty: require.resolve('tty-browserify'),
            },
            alias: {
                jQuery: 'jquery',
            },
        },
    };
});

if (COMPILE == "all" || COMPILE == "js") {
    // update public path for js to compile into /resources
    mix.js("resources/assets/js/admin.js", "js/vendor/admin_compiled.js");
    mix.js("resources/assets/js/website.js", "js/vendor/website_compiled.js");

    mix.scripts(
        [
            "public/js/vendor/admin_compiled.js",
            pathJS + "/titan/buttons.js",
            pathJS + "/titan/datatables.js",
            pathJS + "/titan/forms.js",
            pathJS + "/titan/google_maps.js",
            pathJS + "/titan/notifications.js",
            pathJS + "/titan/notify.js",
            pathJS + "/titan/pagination.js",
            pathJS + "/titan/social_media.js",
            pathJS + "/titan/utils.js",
            pathJS + "/titan/titan.js"
        ],
        publicPath + "/js/admin.js"
    );

    //website js
    mix.scripts(
        [
            "public/js/vendor/website_compiled.js",
            pathJS + "/titan/buttons.js",
            // pathJS + '/titan/datatables.js',
            pathJS + "/titan/forms.js",
            pathJS + "/titan/google_maps.js",
            pathJS + "/titan/pagination.js",
            pathJS + "/titan/social_media.js",
            pathJS + "/titan/utils.js",
            pathJS + "/titan/titan.js",

            pathJS + "/website/utils.js",
        ],
        publicPath + "/js/website.js"
    );
}

if (COMPILE == "all" || COMPILE == "css") {
    mix.sass("resources/assets/sass/admin.scss", "public/css");
    mix.sass("resources/assets/sass/website.scss", "public/css");
}
