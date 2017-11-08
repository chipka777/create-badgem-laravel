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
Route::group(['namespace' => 'API', 'prefix' => 'v1'], function() {
    Route::get('categories', 'CategoriesController@getAll');
    Route::get('images/{category_id}/{count}/{offset}', 'ImagesController@getImagesByCount');
});

