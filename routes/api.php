<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


/*
|------------------------------------------
| PUBLIC API
|------------------------------------------
*/
Route::group(['namespace' => 'Api'], function () { // 'middleware' => ['auth:api'],
    // notifications
    Route::group(['prefix' => 'notifications',], function () {
        Route::post('/{user}', 'NotificationsController@index');
        Route::post('/{user}/unread', 'NotificationsController@unread');
        Route::post('/{user}/read/{notification}', 'NotificationsController@read');

        Route::post('/actions/latest', 'NotificationsController@getLatestActions');
    });

    // analytics
    Route::group(['prefix' => 'analytics'], function () {
        Route::post('/session-group', 'AnalyticsController@getSessionGroup');
        Route::post('/visitors', 'AnalyticsController@getVisitors');
        Route::post('/browsers', 'AnalyticsController@getBrowsers');
        Route::post('/referrers', 'AnalyticsController@getReferrers');
        Route::post('/bounce-rate', 'AnalyticsController@getBounceRate');
        Route::post('/visited-pages', 'AnalyticsController@getVisitedPages');
        Route::post('/active-visitors', 'AnalyticsController@getActiveVisitors');
        Route::post('/unique-visitors', 'AnalyticsController@getUniqueVisitors');
        Route::post('/visitors-views', 'AnalyticsController@getVisitorsAndPageViews');
        Route::post('/visitors/locations', 'AnalyticsController@getVisitorsLocations');

        Route::post('/sessions-engaged', 'AnalyticsController@getAvgEngagementRate');
        Route::post('/engagement-views-time', 'AnalyticsController@getVisitorsAndEngagementTime');
        Route::post('/event-count-name', 'AnalyticsController@getEventCountName');
        Route::post('/event-count', 'AnalyticsController@getEventCount');
        Route::post('/engaged-sessions-user', 'AnalyticsController@getEngagedSessionUsers');
        Route::post('/engagement-time-user', 'AnalyticsController@getEngagementTimeUser');

        Route::post('/resolution', 'AnalyticsController@getResolutions');
        Route::post('/age', 'AnalyticsController@getUsersAge');
        Route::post('/devices', 'AnalyticsController@getDevices');
        Route::post('/gender', 'AnalyticsController@getUsersGender');
        Route::post('/device-category', 'AnalyticsController@getDeviceCategory');

    });
});
