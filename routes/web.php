<?php

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

Route::get('/', 'MainController@index')->name('main');

/*Route::get('/script', function() {
    $images = \App\Image::all();

    foreach($images as $image) {
        var_dump(exec('convert "upload/' . $image->name . '"  -trim "upload/' . $image->name . '"'));
        echo "<br>";
    }
});*/

Auth::routes();

Route::group(['prefix' => 'dashboard', 'namespace' => 'Admin', 'middleware' => 'auth'], function() {
    Route::get('/', 'DashboardController@index')->name('admin');
    Route::resource('categories', 'CategoriesController');
    Route::resource('images', 'ImagesController');
    Route::post('/images/{cat_id}', 'ImagesController@store');

});


Route::get('/download', 'DownloadController@getBadgem');
