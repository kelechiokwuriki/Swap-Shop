<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('listings', 'Api\ListingApiController');
    Route::resource('events', 'Api\EventApiController');

    //todo middleware for only admin
    Route::middleware('checkRole')->group(function () {
        Route::resource('users', 'Api\UserApiController');
    });
});
