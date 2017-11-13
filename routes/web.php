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

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Auth::routes();

Route::get('/', function () {
	if(Auth::check()){
		return redirect('/home');
	}
    return view('auth.login');
});

Route::get('/logout',function(){
	Auth::logout();
	return view('auth.login');
});

Route::group(['middleware' => 'auth'], function () {
	
	Route::get('/home', 'AnimalsController@viewMyAnimals')->name('home');
	
	Route::get('/top-animals', 'AnimalsController@viewTopScore')->name('top');
	
	Route::get('/animals/create', 'AnimalsController@create')->name('create-animal-form');
	
	Route::post('/animals', 'AnimalsController@store');
	
	Route::get('/animals/form-part-loader/{type}/{subtype}', 'AnimalsController@loadFormPart');
	
	Route::get('/matches/play', 'PlayMatchesController@play')->name('play');
	
	Route::post('/matches', 'PlayMatchesController@vote');
	
});