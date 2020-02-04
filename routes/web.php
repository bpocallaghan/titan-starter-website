<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::redirect('/home', '/');

/*
|------------------------------------------
| Website
|------------------------------------------
*/

Route::group(['namespace' => 'Website'], function () {
    Route::get('/', 'HomeController@index')->name('home');
});

/*
|------------------------------------------
| Authenticate User
|------------------------------------------
*/
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    // logout (allow get and post)
    Route::any('logout', 'LoginController@logout')->name('logout');

    Route::group(['middleware' => 'guest'], function () {
        // login
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login');

        // registration
        Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'RegisterController@register');
    });

    // password reset (authenticated user can view as well)
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');

    // email verification
    Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');
});

/*
|------------------------------------------
| Admin (when authorized and admin)
|------------------------------------------
*/
Route::group(['middleware' => ['auth', 'auth.admin'], 'prefix' => 'admin', 'namespace' => 'Admin'], function () {

    Route::get('/', 'DashboardController@index');

    Route::resource('banners', 'Banners\BannersController');

    // history
    Route::group(['prefix' => 'activities', 'namespace' => 'LatestActivities'], function () {
        Route::get('/', 'LatestActivitiesController@website');
        Route::get('/admin', 'LatestActivitiesController@admin');
        Route::get('/website', 'LatestActivitiesController@website');
    });

    // pages
    Route::group(['prefix' => 'pages', 'namespace' => 'Pages'], function () {
        Route::get('/order/{type?}', 'OrderController@index');
        Route::post('/order/{type?}', 'OrderController@updateOrder');

        // manage page sections list order
        Route::get('/{page}/sections', 'PageContentController@index');
        Route::post('/{page}/sections/order', 'PageContentController@updateOrder');
        Route::delete('/{page}/sections/{section}', 'PageContentController@destroy');

        // page components
        Route::resource('/{page}/sections/content', 'PageContentController');
        //remove content media
        Route::post('/{page}/sections/content/{content}/removeMedia', 'PageContentController@removeMedia');
    });
    Route::resource('pages', 'Pages\PagesController');

    // gallery / photos
    Route::group(['prefix' => 'photos', 'namespace' => 'Photos'], function () {
        Route::get('/', 'PhotosController@index');
        Route::delete('/{photo}', 'PhotosController@destroy');
        Route::post('/upload', 'PhotosController@uploadPhotos');
        Route::post('/{photo}/edit/name', 'PhotosController@updatePhotoName');
        Route::post('/{photo}/cover', 'PhotosController@updatePhotoCover');

        Route::resource('/albums', 'AlbumsController', ['except' => 'show']);
        // photoables
        Route::get('/show/{photoable}', 'PhotosController@showPhotos');
        //photos order
        Route::get('/show/{photoable}/order', 'PhotosOrderController@showPhotos');
        Route::post('/order', 'PhotosOrderController@update');
        // croppers
        Route::post('/crop/{photo}', 'CropperController@cropPhoto');
        Route::get('/show/{photoable}/crop/{photo}', 'CropperController@showPhotos');

        // resource image crop
        Route::post('/crop-resource', 'CropResourceController@cropPhoto');
        Route::get('/banners/{banner}/crop-resource/', 'CropResourceController@showBanner');

        //videos
        Route::resource('/albums/{album}/videos', 'VideosController', ['except' => 'show']);

        Route::get('/videos', 'VideosController@index');
        Route::post('/videos/create', 'VideosController@store');
        Route::post('/videos/{video}/edit', 'VideosController@update');
        Route::delete('/videos/{video}', 'VideosController@destroy');
        Route::post('/videos/{video}/getInfo', 'VideosController@videoInfo');
        Route::post('/videos/{video}/cover', 'VideosController@updateVideoCover');
        //videos order
        Route::get('/show/{videoable}/videos/order', 'VideosOrderController@showVideos');
        Route::post('/videos/order', 'VideosOrderController@update');
    });

    // documents
    Route::group(['prefix' => 'documents', 'namespace' => 'Documents'], function () {
        // documents
        Route::get('/', 'DocumentsController@index');
        Route::delete('/{document}', 'DocumentsController@destroy');
        Route::post('/upload', 'DocumentsController@upload');
        Route::post('/{document}/edit/name', 'DocumentsController@updateName');

        // documentable
        Route::get('/category/{category}', 'DocumentsController@showCategory');

        //show documents for other components
        Route::get('/show/{documentable}', 'DocumentsController@showDocuments');

        // categories
        Route::resource('/categories', 'CategoriesController');
    });

    // accounts
    Route::group(['prefix' => 'accounts', 'namespace' => 'Accounts'], function () {
        // clients
        Route::resource('clients', 'ClientsController');

        // users
        Route::get('administrators', 'AdministratorsController@index');
        Route::delete('administrators', 'AdministratorsController@destroy');
    });

    // settings
    Route::group(['prefix' => 'settings', 'namespace' => 'Settings'], function () {
        Route::resource('roles', 'RolesController');

        Route::resource('settings', 'SettingsController');

        // navigation
        Route::get('navigations/order', 'NavigationOrderController@index');
        Route::post('navigations/order', 'NavigationOrderController@updateOrder');
        Route::resource('navigations', 'NavigationsController');
    });
});
