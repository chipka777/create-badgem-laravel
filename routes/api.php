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
    Route::get('categories/all', 'CategoriesController@getAll');
    Route::get('categories', 'CategoriesController@getAllVisibility');
    Route::get('images/count/{category_id}', 'ImagesController@getCountByCategory');
    Route::get('images/{category_id}/{count}/{offset}', 'ImagesController@getImagesByCount');
    Route::get('images/all/{category_id}/{count}/{offset}', 'ImagesController@getImagesByCountAll');
    Route::post('images/instagram', 'ImagesController@getImagesFromInstagram');
    Route::post('images/create', 'ImagesController@createBadgemImage');
    Route::get('bitcoins/ticker', 'BitcoinController@getTicker');
    
    
});

Route::get('cryptopayment/callback', 'Payments\PaymentController@handleCallbackGet');
Route::post('cryptopayment/callback', 'Payments\PaymentController@handleCallbackPost');