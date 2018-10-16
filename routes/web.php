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

\Route::group(['prefix' => 'master-data', 'middleware' => 'auth'], function () {
	Route::resource('/users', 'UserController');
	Route::post('/users/resetPassword/{id}', 'UserController@resetPassword');

	Route::resource('/sizes', 'SizeController');
	Route::resource('/leagues', 'LeagueController');
	Route::resource('/sleeves', 'SleeveController');
	Route::resource('/clubs', 'ClubController');
		
	\Route::group(['prefix' => 'players'], function () {
		Route::get('/', function () {
		    return view('players.index');
		});
		Route::get('/create', function () {
		    return view('players.create');
		});			
	});
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

