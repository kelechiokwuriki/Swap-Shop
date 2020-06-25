<?php

use App\Http\Controllers\Api\ListingApiController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::group(['middleware' => 'auth:web'], function () {
    Route::namespace('admin')->prefix('admin')->name('admin.')->group(function() {
        Route::resource('/users', 'UsersController');
    });

    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('/listings', 'ListingController');
    Route::resource('/events', 'EventController');
});


