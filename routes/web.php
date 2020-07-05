<?php

use App\Http\Controllers\Admin\Users\UserController;
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

Route::get('/terms-of-service', 'TermsOfServiceController@index');


Route::group(['middleware' => ['auth', 'redirectIfNotAuthenticated', 'checkTermsOfServiceAgreement', 'checkUserChangedPassword']], function () {

    Route::middleware('checkrole')->group(function () {
        Route::namespace('Admin')->group(function() {
            Route::resource('/admin', 'AdminController', ['except' => 'show', 'create', 'store']);

            Route::resource('/admin/users', 'Users\UserController');
            Route::resource('/admin/bulletin', 'Bulletin\BulletinController');
        });
    });


    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('/listings', 'ListingController');
    Route::resource('/events', 'EventController');

});


