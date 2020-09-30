<?php

use Illuminate\Support\Facades\Route;

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
    Route::namespace('Banners')->group(function () {
        Route::get('/banners/order', 'OrderController@index');
        Route::post('/banners/order', 'OrderController@update');
        Route::resource('/banners', 'BannersController');
    });

    // faq
    Route::namespace('FAQ')->group(function () {
        Route::resource('/faqs/categories', 'CategoriesController')
            ->names([
                'index' => 'faqs_categories.index',
                'create' => 'faqs_categories.create',
                'store' => 'faqs_categories.store',
                'show' => 'faqs_categories.show',
                'edit' => 'faqs_categories.edit',
                'update' => 'faqs_categories.update',
                'destroy' => 'faqs_categories.destroy',
            ]);
        Route::get('/faqs/order', 'OrderController@index');
        Route::post('/faqs/order', 'OrderController@update');
        Route::resource('/faqs', 'FAQsController');
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
        // resource categories
        Route::resource('/categories', 'CategoriesController')
            ->names([
                'index' => 'resources_categories.index',
                'create' => 'resources_categories.create',
                'store' => 'resources_categories.store',
                'show' => 'resources_categories.show',
                'edit' => 'resources_categories.edit',
                'update' => 'resources_categories.update',
                'destroy' => 'resources_categories.destroy',
            ]);
        // get resources - new photoable, documentable, videoable
        Route::get('/{resourceable}/{resource}', 'ResourceController@showResource');

        //photos - list, delete, upload, edit, cover
        Route::get('/photos', 'PhotosController@index');
        Route::delete('/photos/{photo}', 'PhotosController@destroy');
        Route::post('/photos/upload', 'PhotosController@uploadPhotos');
        Route::post('/photos/{photo}/edit/name', 'PhotosController@updatePhotoName');
        Route::post('/photos/{photo}/cover', 'PhotosController@updatePhotoCover');

        //photos order
        Route::get('/photos/{resourceable}/{resource}/order', 'PhotosOrderController@showPhotos');
        Route::post('/photos/order', 'PhotosOrderController@update');
        // croppers
        Route::get('/photos/crop/{photo}', 'CropperController@showPhotos');
        Route::post('/photos/crop/{photo}', 'CropperController@cropPhoto');

        // resource image crop - featured image (single image file name in resource table)
        Route::get('/{resourceable}/{resource}/crop-resource/', 'CropResourceController@showPhoto');
        Route::post('/photos/crop-resource', 'CropResourceController@cropPhoto');

        //videos - list, create, edit, destroy, getInfo, cover
        Route::get('/videos', 'VideosController@index');
        Route::post('/videos/create', 'VideosController@store');
        Route::post('/videos/{video}/edit', 'VideosController@update');
        Route::delete('/videos/{video}', 'VideosController@destroy');
        Route::post('/videos/{video}/getInfo', 'VideosController@videoInfo');
        Route::post('/videos/{video}/cover', 'VideosController@updateVideoCover');
        //videos order
        Route::get('/videos/{resourceable}/{resource}/order', 'VideosOrderController@showVideos');
        Route::post('/videos/order', 'VideosOrderController@update');

        //documents - list, destroy, upload, edit
        Route::get('/documents', 'DocumentsController@index');
        Route::delete('/documents/{document}', 'DocumentsController@destroy');
        Route::post('/documents/upload', 'DocumentsController@upload');
        Route::post('/documents/{document}/edit/name', 'DocumentsController@updateName');
    });

    // news and events
    Route::group(['prefix' => 'news', 'namespace' => 'News'], function () {
        Route::resource('articles', 'NewsController');
        Route::resource('categories', 'CategoriesController')
            ->names([
                'index' => 'news_categories.index',
                'create' => 'news_categories.create',
                'store' => 'news_categories.store',
                'show' => 'news_categories.show',
                'edit' => 'news_categories.edit',
                'update' => 'news_categories.update',
                'destroy' => 'news_categories.destroy',
            ]);
    });

    // products
    Route::group(['prefix' => 'shop', 'namespace' => 'Shop'], function () {
        Route::get('categories/order', 'CategoriesOrderController@index');
        Route::post('categories/order', 'CategoriesOrderController@updateListOrder');
        Route::resource('categories', 'CategoriesController')
            ->names([
                'index' => 'shop_categories.index',
                'create' => 'shop_categories.create',
                'store' => 'shop_categories.store',
                'show' => 'shop_categories.show',
                'edit' => 'shop_categories.edit',
                'update' => 'shop_categories.update',
                'destroy' => 'shop_categories.destroy',
            ]);
        Route::resource('products', 'ProductsController');
        Route::resource('features', 'FeaturesController');
        Route::resource('status', 'StatusesController');

        Route::get('checkouts', 'CheckoutsController@index');
        Route::get('checkouts/{checkout}', 'CheckoutsController@show');
        Route::get('transactions', 'TransactionsController@index');
        Route::get('transactions/{transaction}', 'TransactionsController@show');
        Route::get(
            'transactions/{transaction}/print/{format?}',
            'TransactionsController@printOrder'
        );
        Route::post('transactions/{transaction}/status', 'TransactionsController@updateStatus');

        Route::get('/searches', 'SearchesController@index');
        Route::get('/searches/datatable', 'SearchesController@getTableData');
        Route::post('/searches/datatable/dates', 'SearchesController@updateDates');
        Route::get('/searches/datatable/reset', 'SearchesController@resetDates');
    });

    // reports
    Route::group(['prefix' => 'reports', 'namespace' => 'Reports'], function () {
        Route::get('summary', 'SummaryController@index');

        // feedback contact us
        Route::get('contact-us', 'ContactUsController@index');
        Route::post('contact-us/chart', 'ContactUsController@getChartData');
        Route::get('contact-us/datatable', 'ContactUsController@getTableData');
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
