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
\Route::group(['middleware' => 'auth'], function () {
Route::get('logout', 'Auth\LoginController@logout');	
Route::get('/', function () {
		    return view('index');
		});
});

Route::get('master-data/users/load-data', 'UserController@loadData');
Route::get('master-data/sizes/load-data', 'SizeController@loadData');
Route::get('master-data/leagues/load-data', 'LeagueController@loadData');
Route::get('master-data/sleeves/load-data', 'SleeveController@loadData');
Route::get('master-data/clubs/load-data', 'ClubController@loadData');
Route::get('master-data/players/load-data', 'PlayerController@loadData');
Route::get('master-data/leagues/get-clubs/{id}', 'LeagueController@getClubs');

Route::get('category-product/category/load-data', 'CategoryController@loadData');
Route::get('category-product/category/get-category-child/{id}', 'CategoryController@getCategoryChild');
Route::get('category-product/product/load-data', 'ProductController@loadData');
Route::get('category-product/product-stock/load-data', 'ProductStockController@loadData');
Route::get('category-product/product-gallery/load-data', 'ProductGalleryController@loadData');

Route::get('order-management/incoming-order/load-data', 'OrderController@loadDataIncomingOrder');
Route::get('order-management/order/load-data', 'OrderController@loadData');

Route::get('report/sales/load-data', 'ReportController@loadDataSales');
Route::get('report/registrant/load-data', 'ReportController@loadDataRegistrant');
Route::get('report/subscriber/load-data', 'ReportController@loadDataSubscriber');
Route::get('report/contact-us/load-data', 'ReportController@loadDataContactUs');

\Route::group(['prefix' => 'master-data', 'middleware' => 'auth'], function () {
	Route::resource('/users', 'UserController');
	Route::post('/users/resetPassword/{id}', 'UserController@resetPassword');

	Route::resource('/sizes', 'SizeController');
	Route::resource('/leagues', 'LeagueController');
	Route::resource('/sleeves', 'SleeveController');
	Route::resource('/clubs', 'ClubController');
	Route::resource('/players', 'PlayerController');
});

\Route::group(['prefix' => 'category-product', 'middleware' => 'auth'], function () {
	Route::resource('/category', 'CategoryController');
	Route::resource('/product', 'ProductController');
	Route::resource('/product-stock', 'ProductStockController');
	Route::resource('/product-gallery', 'ProductGalleryController');
});

Route::get('web-management/home/load-data', 'HomeBannerController@loadData');
Route::get('web-management/adsInventory/load-data', 'AdsInventoryController@loadData');

\Route::group(['prefix' => 'web-management', 'middleware' => 'auth'], function () {
	Route::resource('/home', 'HomeBannerController');
	Route::resource('/adsInventory', 'AdsInventoryController');
	Route::resource('/privacyPolicy', 'PrivacyPolicyController');
	Route::resource('/termUser', 'TermUserController');
	Route::resource('/aboutUs', 'AboutUsController');
	Route::resource('/contactUs', 'ContactUsController');
});

\Route::group(['prefix' => 'order-management', 'middleware' => 'auth'], function () {
	Route::resource('/order', 'OrderController');
	Route::post('order/confirm-order/{id}', 'OrderController@confirmOrder');
	Route::post('order/ignore-order/{id}', 'OrderController@ignoreOrder');
	Route::post('order/confirm-shipment-order/{id}', 'OrderController@confirmShipmentOrder');	
	Route::post('order/update-internal-note-order/{id}', 'OrderController@updateInternalNote');
	Route::get('incoming-order', 'OrderController@incomingOrderIndex');
	Route::get('order/item/{id}', 'OrderController@showItem');
});

\Route::group(['prefix' => 'report', 'middleware' => 'auth'], function () {
	Route::get('sales', 'ReportController@indexSales');
	Route::get('registrant', 'ReportController@indexRegistrant');
	Route::get('subscriber', 'ReportController@indexSubscriber'); 
	Route::get('contact-us', 'ReportController@indexContactUs');
});

Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');

