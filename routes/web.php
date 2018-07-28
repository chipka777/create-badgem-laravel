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

Auth::routes();

Route::post('/activate', 'Auth\\RegisterController@activate');

Route::post('/password-recovery', 'Auth\\ForgotPasswordController@recovery');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'MainController@index')->name('main');
    Route::get('/download', 'DownloadController@getBadgem');
});

Route::group(['middleware' => 'role:administrator'], function() {
    Route::post('/user/send-invite', 'Admin\\UsersController@sendInvite'); 
});

/*Route::get('/test', 'API\Website\InstagramController@getImages');
Route::get('/instagram-auth', 'API\Website\InstagramController@authCallback');
*/

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

    Route::get('/products/cap', 'Products\CapController@index')->name('products.cap.index');
    Route::get('/products/cap/get/{count}/{offset}', 'Products\CapController@getByCount')->name('products.cap.getByCount');    
    Route::post('/products/cap/create', 'Products\CapController@create')->name('products.cap.create');
    Route::post('/products/cap/edit', 'Products\CapController@edit')->name('products.cap.edit');    
    Route::post('/products/cap/delete-extra', 'Products\CapController@deleteExtra')->name('products.cap.delete-extra');        
    Route::delete('/products/cap/delete/{id}', 'Products\CapController@delete')->name('products.cap.delete');        

    Route::resource('faq', 'FAQController');
    Route::resource('goals', 'GoalsController');    
    Route::post('/team/{id}', 'TeamController@update');        
    Route::resource('team', 'TeamController');    

    Route::get('/team/{count}/{offset}', 'TeamController@getByCount'); 
    Route::get('/goals/{count}/{offset}', 'GoalsController@getByCount');           
    Route::get('/faq/{count}/{offset}', 'FAQController@getByCount');

    Route::resource('videos', 'VideoController');
    Route::resource('bulletin', 'BulletinController');    
    Route::get('/bulletin/get/{count}/{offset}', 'BulletinController@getByCount')->name('bulletin.getByCount');        
    Route::get('/videos/get/{count}/{offset}', 'VideoController@getByCount')->name('videos.cap.getByCount');    
    
    
});

Route::group(['namespace' => 'API', 'prefix' => 'api/v1'], function() {
    Route::group(['namespace' => 'Admin'], function() {
        Route::get('notifications/{offset}/{count}', 'Notifications\\MainController@getByCount');
        Route::get('notifications/set-as-read', 'Notifications\\MainController@setAsRead');
        Route::get('history/{offset}/{count}/{id}', 'History\MainController@getByCount');     
          
    });

    Route::group(['namespace' => 'Website'], function() {
        Route::get('categories/all', 'CategoriesController@getAll');
        Route::get('categories', 'CategoriesController@getAllVisibility');
        Route::get('images/count/{category_id}', 'ImagesController@getCountByCategory');
        Route::get('images/count-by-user/{category_id}', 'ImagesController@getCountByUser');    
        Route::get('images/all/{category_id}/{count}/{offset}', 'ImagesController@getImagesByCountAll');
        Route::get('images/by-user/{category_id}/{count}/{offset}', 'ImagesController@getImagesByUser');    
        Route::post('images/instagram', 'ImagesController@getImagesFromInstagram');
        Route::post('images/create', 'ImagesController@createBadgemImage');
        Route::get('images/add-to-favorite/{id}', 'ImagesController@addToFavorite');
        Route::get('images/remove-from-favorite/{id}', 'ImagesController@removeFromFavorite');
        Route::post('set-activity', 'ActivityController@setActivity');
        Route::get('check-activity', 'ActivityController@checkActivity');

        Route::get('images/{category_id}/{count}/{offset}', 'ImagesController@getImagesByCount');        
        Route::get('bulletins/{count}/{offset}', 'BulletinController@getBulletins');
        Route::get('creations/{count}/{offset}', 'ImagesController@getCreations');
        Route::get('favorites/{count}/{offset}', 'ImagesController@getFavorites');
        Route::get('team/{count}/{offset}', 'TeamController@getTeamMembers');        
        Route::get('goals/{count}/{offset}', 'GoalsController@getGoals');                
        Route::get('histories/{count}/{offset}', 'HistoryController@getHistoryByCount');                
        Route::get('faq/{count}/{offset}', 'FAQController@getByCount');          
        
        Route::get('products/all/{count}/{offset}', 'ProductsController@getAllByCount');        
        Route::get('products/{type}/{count}/{offset}', 'ProductsController@getProductsByTypeAndCount');

        Route::post('set-to-history', 'HistoryController@setToHistory');

        Route::get('videos/{count}/{offset}', 'VideoController@getByCount');
        
    });
});

