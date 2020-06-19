<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'Website'], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/news/{categorySlug?}', 'NewsController@index')->name('news');
    Route::get('/articles/{categorySlug}/{newsSlug}', 'NewsController@show');

    Route::get('/contact-us', 'ContactUsController@index')->name('contact');
    Route::post('/contact-us/submit', 'ContactUsController@feedback');

    // faq
    Route::namespace('FAQ')->group(function () {
        Route::get('/faq', 'FAQController@index');
        Route::post('/faq/question/{faq}/{type?}', 'FAQController@incrementClick');
    });

    // shop
    Route::group(['namespace' => 'Shop'], function () {
        Route::post('/products/filter', 'ShopController@filter');
        Route::get('/products/basket', 'BasketController@index');
        Route::post('/products/basket', 'BasketController@submitBasket');
        Route::get('/products/show/{productSlug}', 'ShopController@show');

        Route::group(['middleware' => ['auth']], function () {
            Route::get('/products/basket/address', 'BasketController@showAddress');
            Route::post('/products/basket/address', 'BasketController@submitAddress');
            Route::get('/products/basket/checkout', 'BasketController@showCheckout');
            Route::post('/products/basket/checkout', 'BasketController@submitCheckout');
            Route::get('/products/basket/checkout/feedback', 'BasketController@showCheckoutFeedback');
            Route::get('/products/basket/add/{product}/{quantity?}', 'BasketController@addProduct');
            Route::get('/products/basket/remove/{product}', 'BasketController@removeProduct');
        });

        Route::get('/products/{slugs?}', 'ShopController@index')->where('slugs', '(.*)');
    });
});

/*
|------------------------------------------
| Website Account
|------------------------------------------
*/
Route::group(
    ['middleware' => ['auth'], 'prefix' => 'account', 'namespace' => 'Website\Account'],
    function () {
        Route::get('/', 'AccountController@index')->name('account');
        Route::get('/profile', 'ProfileController@index')->name('profile');
        Route::post('/profile', 'ProfileController@update');
        Route::get('/orders', 'AccountController@transactions');
        Route::get('/orders/{reference}', 'AccountController@showTransaction');
        Route::get('/orders/{reference}/print', 'AccountController@printTransaction');

        Route::get('/address', 'ShippingAddressController@index');
        Route::post('/address', 'ShippingAddressController@update');
    }
);

/*
|------------------------------------------
| Authenticate User
|------------------------------------------
*/
Route::group(['prefix' => 'auth'], function () {
    Auth::routes(['verify' => true]);

    // Route::any('logout', 'Auth\LoginController@logout')->name('logout');
});

/*
|------------------------------------------
| Dynamic Pages - up to 3 slugs
|------------------------------------------
*/
Route::group(['namespace' => 'Website'], function () {
    Route::get('{slug1}/{slug2?}/{slug3?}', 'PagesController@index');
});
