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
Route::post('/activate', 'Auth\\RegisterController@activate');

Route::group(['middleware' => 'role:administrator'], function() {
    Route::post('/user/send-invite', 'Admin\\UsersController@sendInvite'); 
});

Route::group(['prefix' => 'dashboard', 'namespace' => 'Admin', 'middleware' => 'auth'], function() {
    Route::get('/', 'DashboardController@index')->name('admin');
    Route::resource('categories', 'CategoriesController');
    Route::get('/images/all', 'ImagesController@showAll')->name('images.showAll');    
    Route::resource('images', 'ImagesController');
    Route::post('/images/{cat_id}', 'ImagesController@store');
    Route::get('/users', 'UsersController@index');
    Route::get('/favorites', 'DashboardController@favorite');
    Route::get('/become-designer', 'DashboardController@becomeDesigner');    
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');
    Route::post('/profile/edit', 'ProfileController@store')->name('profile.edit.post');
    Route::get('/profile/change-password', 'ProfileController@changePasswordShow')->name('change-password');   
    Route::post('/profile/change-password', 'ProfileController@changePassword')->name('profile.change-password.post');    
    Route::get('/profile/{id}', 'UsersController@showProfile')->name('users.show');
    Route::get('/profile/edit/{id}', 'UsersController@edit')->name('users.edit');
    Route::post('/profile/edit/{id}', 'UsersController@store')->name('users.edit.post');
    Route::post('/become-designer/become', 'DashboardController@activateDesigner')->name('become-designer');

});

Route::group(['namespace' => 'API', 'prefix' => 'api/v1'], function() {
    Route::get('categories/all', 'CategoriesController@getAll');
    Route::get('categories', 'CategoriesController@getAllVisibility');
    Route::get('images/count/{category_id}', 'ImagesController@getCountByCategory');
    Route::get('images/count-by-user/{category_id}', 'ImagesController@getCountByUser');    
    Route::get('images/{category_id}/{count}/{offset}', 'ImagesController@getImagesByCount');
    Route::get('images/all/{category_id}/{count}/{offset}', 'ImagesController@getImagesByCountAll');
    Route::get('images/by-user/{category_id}/{count}/{offset}', 'ImagesController@getImagesByUser');    
    Route::post('images/instagram', 'ImagesController@getImagesFromInstagram');
    Route::post('images/create', 'ImagesController@createBadgemImage');
    Route::get('bitcoins/ticker', 'BitcoinController@getTicker');
    Route::get('images/add-to-favorite/{id}', 'ImagesController@addToFavorite');
    Route::get('images/remove-from-favorite/{id}', 'ImagesController@removeFromFavorite');
    Route::get('notifications/{offset}/{count}', 'Notifications\\MainController@getByCount');
    Route::get('notifications/set-as-read', 'Notifications\\MainController@setAsRead');
    Route::get('history/{offset}/{count}/{id}', 'History\MainController@getByCount');    
    
});

Route::get('/download', 'DownloadController@getBadgem');
