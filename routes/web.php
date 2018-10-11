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

\Route::group(['prefix' => 'master-data', 'middleware' => 'auth'], function () {
	\Route::group(['prefix' => 'users'], function () {
		Route::get('/', function () {
		    return view('users.index');
		});
		Route::get('/create', function () {
		    return view('users.create');
		});			
	});
	\Route::group(['prefix' => 'clubs'], function () {
		Route::get('/', function () {
		    return view('clubs.index');
		});
		Route::get('/create', function () {
		    return view('clubs.create');
		});			
	});
	\Route::group(['prefix' => 'leagues'], function () {
		Route::get('/', function () {
		    return view('leagues.index');
		});
		Route::get('/create', function () {
		    return view('leagues.create');
		});			
	});	
	\Route::group(['prefix' => 'players'], function () {
		Route::get('/', function () {
		    return view('players.index');
		});
		Route::get('/create', function () {
		    return view('players.create');
		});			
	});
	\Route::group(['prefix' => 'sizes'], function () {
		Route::get('/', function () {
		    return view('sizes.index');
		});
		Route::get('/create', function () {
		    return view('sizes.create');
		});			
	});
	\Route::group(['prefix' => 'sleeves'], function () {
		Route::get('/', function () {
		    return view('sleeves.index');
		});
		Route::get('/create', function () {
		    return view('sleeves.create');
		});			
	});
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
