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

    // profile
    Route::get('/profile', 'ProfileController@index');
    Route::put('/profile/{user}', 'ProfileController@update');

    // analytics
    Route::group(['prefix' => 'analytics'], function () {
        Route::get('/summary', 'AnalyticsController@summary');
        Route::get('/devices', 'AnalyticsController@devices');
        Route::get('/visits-and-referrals', 'AnalyticsController@visitsReferrals');
        Route::get('/interests', 'AnalyticsController@interests');
        Route::get('/demographics', 'AnalyticsController@demographics');
    });

    // banners
    Route::namespace('Banners')->group(function(){
        Route::get('/banners/order', 'OrderController@index');
        Route::post('/banners/order', 'OrderController@update');
        Route::resource('/banners', 'BannersController');
    });

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

    // resources
    Route::group(['prefix' => 'resources', 'namespace' => 'Resources'], function () {
        // get resources
        Route::get('/{resourceable}/{resource}', 'ResourceController@showResource');
        // resource categories
        Route::resource('/categories', 'CategoriesController');
        //photos
        Route::get('/photos', 'PhotosController@index');
        Route::delete('/photos/{photo}', 'PhotosController@destroy');
        Route::post('/photos/upload', 'PhotosController@uploadPhotos');
        Route::post('/photos/{photo}/edit/name', 'PhotosController@updatePhotoName');
        Route::post('/photos/{photo}/cover', 'PhotosController@updatePhotoCover');
        // photoables
        Route::get('/photos/show/{photoable}', 'PhotosController@showPhotos');
        //photos order
        Route::get('/photos/{resourceable}/{resource}/order', 'PhotosOrderController@showPhotos');
        Route::post('/photos/order', 'PhotosOrderController@update');
        // croppers
        Route::get('/photos/crop/{photo}', 'CropperController@showPhotos');
        Route::post('/photos/crop/{photo}', 'CropperController@cropPhoto');
        // resource image crop
        Route::get('/banners/{banner}/crop-resource/', 'CropResourceController@showBanner');
        Route::post('/photos/crop-resource', 'CropResourceController@cropPhoto');

        //videos
        Route::get('/videos', 'VideosController@index');
        Route::post('/videos/create', 'VideosController@store');
        Route::post('/videos/{video}/edit', 'VideosController@update');
        Route::delete('/videos/{video}', 'VideosController@destroy');
        Route::post('/videos/{video}/getInfo', 'VideosController@videoInfo');
        Route::post('/videos/{video}/cover', 'VideosController@updateVideoCover');
        //videos order
        Route::get('/videos/{resourceable}/{resource}/order', 'VideosOrderController@showVideos');
        Route::post('/videos/order', 'VideosOrderController@update');

        //documents
        Route::get('/documents', 'DocumentsController@index');
        Route::delete('/documents/{document}', 'DocumentsController@destroy');
        Route::post('/documents/upload', 'DocumentsController@upload');
        Route::post('/documents/{document}/edit/name', 'DocumentsController@updateName');
        // documentable
        Route::get('/documents/{documentable}', 'DocumentsController@showDocuments');

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
