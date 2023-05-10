<?php

use App\Models\Page;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::redirect('/home', '/');


Route::group(['namespace' => 'Website'], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/articles/{categorySlug}/{articleSlug}', 'ArticlesController@show')->name('article.show');

    Route::post('/contact/submit', 'ContactUsController@feedback')->name('contact.submit');

    Route::post('/comments/submit', 'CommentsController@comment')->name('comments.submit');

    // faq
    Route::namespace('FAQ')->group(function () {
        Route::post('/faq/question/{faq}/{type?}', 'FAQController@incrementClick')->name('faq.feedback.submit');
    });

    // shop
    Route::group(['namespace' => 'Shop'], function () {
        Route::post('/products/filter', 'ShopController@filter')->name('products_filter');
        Route::get('/products/basket', 'BasketController@index')->name('basket');
        Route::post('/products/basket', 'BasketController@submitBasket')->name('basket.submit');
        Route::get('/products/show/{productSlug}', 'ShopController@show')->name('product.show');

        Route::group(['middleware' => ['auth']], function () {
            Route::get('/products/basket/address', 'BasketController@showAddress')->name('basket.address');
            Route::post('/products/basket/address', 'BasketController@submitAddress')->name('basket.address.submit');
            Route::get('/products/basket/checkout', 'BasketController@showCheckout')->name('basket.show');
            Route::post('/products/basket/checkout', 'BasketController@submitCheckout')->name('basket.checkout.submit');
            Route::get('/products/basket/checkout/feedback', 'BasketController@showCheckoutFeedback')->name('basket.checkout.feedback');
            Route::get('/products/basket/add/{product}/{quantity?}', 'BasketController@addProduct')->name('basket.add.product');
            Route::get('/products/basket/remove/{product}', 'BasketController@removeProduct')->name('basket.remove.product');
        });

        Route::get('/products/{slugs?}', 'ShopController@index')->where('slugs', '(.*)')->name('products.show');
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
        // Route::get('/profile', 'ProfileController@index')->name('profile');
        Route::post('/profile', 'ProfileController@update')->name('profile.submit');
        // Route::get('/orders', 'AccountController@transactions')->name('profile.order');
        Route::get('/orders/{reference}', 'AccountController@showTransaction')->name('profile.order.show');
        Route::get('/orders/{reference}/print', 'AccountController@printTransaction')->name('profile.order.print');

        Route::get('/address', 'ShippingAddressController@index')->name('profile.address');
        Route::post('/address', 'ShippingAddressController@update')->name('profile.address.submit');
    }
);

/*
|------------------------------------------
| Authenticate User
|------------------------------------------
*/
Route::group(['prefix' => 'auth'], function () {
    Auth::routes(['verify' => true]);

    Route::any('logout', 'Auth\LoginController@logout')->name('auth.logout');
});

/*
|------------------------------------------
| Dynamic Pages - up to 3 slugs
|------------------------------------------
*/
Route::group(['namespace' => 'Website'], function () {

    // un-comment the "if (!App::runningInConsole())" statement ONLY once project is set up and migrations have been run
    // run "php artisan cache:clear", "php artisan route:clear", "php artisan config:clear" in order to load custom templates
    // avoid running "php artisan optimize" as this created cached files and causes issues when renaming pages
    if (!App::runningInConsole()) {
        $pages = Page::whereNotNull('template_id')->get();

        foreach ($pages as $page) {
            $name = $page->slug;

            if (isset($page->template->controller_action) && $page->template->controller_action != 'Auth') {
                Route::get($page->url, $page->template->controller_action)->name($name);
            }
            else if(!isset($page->template->controller_action)){
                Route::get($page->url, 'PagesController@index')->name($name);
            }
        }
    }

    Route::get('{slug1}/{slug2?}/{slug3?}', 'PagesController@index');
});