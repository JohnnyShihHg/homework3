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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//會員相關
Route::group(['prefix' => 'user'], function () {
    Route::post('/signup', 'UserAuthController@signup');
    Route::post('/login', 'UserAuthController@login');
    Route::post('/resetPassword', 'UserAuthController@resetPassword');
    Route::post('/logout', 'UserAuthController@logout');
});

//商品相關
Route::get('/productCategory', 'ProductCategoryController@index');

//訂單相關
Route::group(['prefix' => 'order'], function () {
    Route::get('/', 'OrderController@index');
    Route::middleware(['jwt.auth'])->group(function () {
        Route::post('/', 'OrderController@store');
        Route::get('/detail/{order_no}', 'OrderController@detail');
    });
});

//購物車
Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/cart', 'CartController@store');
});
