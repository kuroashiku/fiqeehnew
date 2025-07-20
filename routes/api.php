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

Route::post('register', 'AuthController@registerPost');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('search/course', 'HomeController@ajaxClass');
Route::get('produk/', 'Usercontroller@getProduct');
Route::get('user/sendOTP', 'AuthController@ajaxOTP');
Route::get('user/sendBlasting', 'BlastingController@sendAutoBlasting');
Route::post('storeTime', 'CourseController@storeTime')->name('storeTime');
