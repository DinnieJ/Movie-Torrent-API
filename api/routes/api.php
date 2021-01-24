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
Route::group(['prefix' => 'movie'], function () {
    Route::get('/all', 'MovieController@getAll');
    Route::get('/detail/{id}', 'MovieController@getMovie');

    Route::group(['middleware' => 'auth.jwt'], function () {
        Route::get('/userfavorite', 'MovieController@getUserMovie');
    });
});

Route::group(['prefix' => 'favorite', 'middleware' => 'auth.jwt'], function () {
    Route::post('/add', 'FavoriteController@addFavorite');
    Route::post('/remove', 'FavoriteController@removeFavorite');
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', 'AuthController@login');
    Route::group(['middleware' => 'auth.jwt'], function () {
        Route::post('/logout', 'AuthController@logout');
        Route::get('/user', 'AuthController@info');
    });
});
Route::group(['prefix' => 'car'], function () {


    Route::get('/all', 'CarController@getAllCar');
    Route::get('/detail', 'CarController@getCar');
    Route::post('/create', 'CarController@createCar');
    Route::put('/update', 'CarController@updateCar');
    Route::delete('/delete', 'CarController@deleteCar');

});
