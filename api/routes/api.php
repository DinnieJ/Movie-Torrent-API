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
    Route::get('/', 'MovieController@getAll');
    Route::get('/detail/{id}', 'MovieController@getMovie');
    Route::get('/random', 'MovieController@getRandomFive');
    Route::get('/search', 'MovieController@searchMovie');
    Route::group(['middleware' => 'auth.jwt'], function () {
        Route::get('/user-favorite', 'MovieController@getUserMovie');
    });
});

Route::group(['prefix' => 'favorite', 'middleware' => 'auth.jwt'], function () {
    Route::post('/add', 'FavoriteController@addFavorite');
    Route::post('/remove', 'FavoriteController@removeFavorite');
});

Route::group(['prefix' => 'comment', 'middleware' => 'auth.jwt'], function () {
    Route::post('/add', 'CommentController@addComment');
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', 'AuthController@login');
    Route::group(['middleware' => 'auth.jwt'], function () {
        Route::post('/logout', 'AuthController@logout');
        Route::get('/user', 'AuthController@info');
    });
});

Route::get('/testshit', 'MovieController@testMovie');
