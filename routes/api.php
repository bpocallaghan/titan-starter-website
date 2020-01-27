<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

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
});
