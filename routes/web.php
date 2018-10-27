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
});

Route::get('web-management/home/load-data', 'HomeBannerController@loadData');
Route::get('web-management/adsInventory/load-data', 'AdsInventoryController@loadData');
// Route::get('web-management/privacyPolicy/load-data', 'PrivacyPolicyController@loadData');
// Route::get('web-management/termUser/load-data', 'TermUserController@loadData');
// Route::get('web-management/aboutUs/load-data', 'AboutUsController@loadData');
// Route::get('web-management/contactUs/load-data', 'ContactUsController@loadData');

\Route::group(['prefix' => 'web-management', 'middleware' => 'auth'], function () {
	Route::resource('/home', 'HomeBannerController');
	Route::resource('/adsInventory', 'AdsInventoryController');
	Route::resource('/privacyPolicy', 'PrivacyPolicyController');
	Route::resource('/termUser', 'TermUserController');
	Route::resource('/aboutUs', 'AboutUsController');
	Route::resource('/contactUs', 'ContactUsController');
});

Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');

