<?php

use Illuminate\Support\Facades\Route;

/*
|------------------------------------------
| Admin (when authorized and admin)
|------------------------------------------
*/
Route::group(['middleware' => ['auth', 'auth.admin'], 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/', 'DashboardController@index');

    //comments
    Route::group([ 'namespace' => 'Comments'], function () {
        Route::resource('comments', 'CommentsController');
    });

    // profile
    Route::get('/profile', 'ProfileController@index');
    Route::put('/profile/{user}', 'ProfileController@update');

    // analytics
    Route::group(['prefix' => 'analytics'], function () {
        Route::get('/summary', 'AnalyticsController@summary');
        Route::get('/devices', 'AnalyticsController@devices');
        Route::get('/visits-and-referrals', 'AnalyticsController@visitsReferrals');
        Route::get('/engagement', 'AnalyticsController@engagement');
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

    //locations
    Route::group(['prefix' => 'locations', 'namespace' => 'Locations'], function () {
        //Route::resource('branches', 'BranchesController');
        Route::resource('suburbs', 'SuburbsController');
        Route::resource('cities', 'CitiesController');
        Route::resource('provinces', 'ProvincesController');
        Route::resource('countries', 'CountriesController');
        Route::resource('continents', 'ContinentsController');
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
    });
    Route::resource('pages', 'Pages\PagesController');

    // news and events
    Route::group(['prefix' => 'news','namespace' => 'Articles'], function () {
        Route::resource('articles', 'ArticlesController');
        Route::resource('categories', 'CategoriesController')
            ->names([
                'index' => 'articles_categories.index',
                'create' => 'articles_categories.create',
                'store' => 'articles_categories.store',
                'show' => 'articles_categories.show',
                'edit' => 'articles_categories.edit',
                'update' => 'articles_categories.update',
                'destroy' => 'articles_categories.destroy',
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

        Route::resource('templates', 'TemplatesController');

        Route::resource('layouts', 'LayoutsController');

        // navigation
        Route::get('navigations/order', 'NavigationOrderController@index');
        Route::post('navigations/order', 'NavigationOrderController@updateOrder');
        Route::resource('navigations', 'NavigationsController');
    });

    Route::group(['namespace' => 'Resources'], function () {

        // resource image crop - featured image (single image file name in resource table) - for banners
        Route::get('/{resourceable}/{resource}/crop-resource/', 'CropResourceController@showPhoto');

        // get resources - new photoable, documentable, videoable
        Route::get('/{resourceable1}/{resourceable2}/{resource}/resources', 'ResourceController@showResource');

        Route::group(['prefix' => 'resources'], function () {
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

            //photos - list, delete, upload, edit, cover
            Route::get('/photos', 'PhotosController@index');
            Route::delete('/photos/{photo}', 'PhotosController@destroy');
            Route::post('/photos/upload', 'PhotosController@uploadPhotos');
            Route::post('/photos/{photo}/edit/name', 'PhotosController@updatePhotoName');
            Route::post('/photos/{photo}/cover', 'PhotosController@updatePhotoCover');

            //photos order
            Route::get('/photos/{resourceable}/{resource}/order', 'PhotosOrderController@showPhotos');
            Route::post('/photos/order', 'PhotosOrderController@update');

            // attach existing photos
            Route::post('/photos/attach', 'PhotosController@attach');

            // croppers
            Route::get('/photos/crop/{photo}', 'CropperController@showPhotos');
            Route::post('/photos/crop/{photo}', 'CropperController@cropPhoto');

            // resource image crop - featured image (single image file name in resource table) - for page content
            Route::get('/{resourceable}/{resource}/crop-resource/', 'CropResourceController@showPhoto');
            Route::post('/photos/crop-resource', 'CropResourceController@cropPhoto');

            //videos - list, create, edit, destroy, getInfo, cover
            Route::get('/videos', 'VideosController@index');
            Route::post('/videos/create', 'VideosController@store');
            Route::post('/videos/{video}/edit', 'VideosController@update');
            Route::delete('/videos/{video}', 'VideosController@destroy');
            Route::post('/videos/{video}/getInfo', 'VideosController@videoInfo');
            Route::post('/videos/{video}/cover', 'VideosController@updateVideoCover');
            //upload videos
            Route::post('/videos/upload', 'VideosController@uploadVideos');
            Route::post('/videos/{video}/edit/name', 'VideosController@updateVideoName');
            // attach existing videos
            Route::post('/videos/attach', 'VideosController@attach');

            //videos order
            Route::get('/videos/{resourceable}/{resource}/order', 'VideosOrderController@showVideos');
            Route::post('/videos/order', 'VideosOrderController@update');

            //documents - list, destroy, upload, edit
            Route::get('/documents', 'DocumentsController@index');
            Route::delete('/documents/{document}', 'DocumentsController@destroy');
            Route::post('/documents/upload', 'DocumentsController@upload');
            Route::post('/documents/{document}/edit/name', 'DocumentsController@updateName');
            //documents order
            Route::get('/documents/{resourceable}/{resource}/order', 'DocumentsOrderController@showDocuments');
            Route::post('/documents/order', 'DocumentsOrderController@update');
            // attach existing documents
            Route::post('/documents/attach', 'DocumentsController@attach');
        });

        // sections
        Route::resource('/{resourceable}/{resource}/sections', 'SectionsController');
        Route::post('/{resourceable}/{resource}/sections/{section}/content/attach', 'SectionsController@attach');
        // order sections
        Route::post('/{resourceable}/{resource}/sections/order', 'SectionsController@updateOrder');
        //content
        Route::resource('/{resourceable}/{resource}/sections/{section}/content', 'ContentController');
        Route::post('/{resourceable}/{resource}/sections/{section}/content/{content}/remove', 'ContentController@remove');
        //order content
        Route::post('/{resourceable}/{resource}/sections/{section}/content/order', 'ContentController@updateOrder');
        //remove content media
        Route::post('/{resourceable}/{resource}/sections/{section}/content/{content}/removeMedia', 'ContentController@removeMedia');
        //view contents
        Route::get('/resources/content/', 'ContentController@show');
        //delete content
        Route::delete('/content/{content}', 'ContentController@deleteContent');
    });

});
