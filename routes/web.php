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

Route::redirect('/home', '/');

/*
|------------------------------------------
| Website
|------------------------------------------
*/

Route::view('/', 'welcome')->name('home');
Route::group(['namespace' => 'Website'], function () {
    //Route::get('/', 'HomeController@index')->name('home');
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
    //Route::group(['prefix' => 'settings', 'namespace' => 'Settings'], function () {
    //    Route::resource('roles', 'RolesController');
    //    Route::resource('navigations', 'NavigationsController');
    //});
});
