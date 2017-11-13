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
	
	Route::get('/home', 'HomeController@index')->name('home');
	
	Route::get('/animals/create', 'AnimalsController@create')->name('create-animal-form');
	
	Route::post('/animals', 'AnimalsController@store');
	
	Route::get('/animals/form-part-loader/{type}/{subtype}', 'AnimalsController@loadFormPart');
	
	Route::get('/matches/play', 'PlayMatchesController@play')->name('play');
	
});

/**
 * **********************TEST***********************************
 */

Route::get('/test', function(\App\Services\UserMatchServiceInterface $userMatch){
	$userMatch->saveMatchesForUser();
});

Route::get('/rest', function(\App\Services\MatchServiceInterface $allMatch){
	dd($allMatch->compileMatchMap()->saveMatchMap());
});

Route::get('/qwest',function(Request $request){
	dump($request->url());
	dump($request->fullUrl());
	echo print_r($_GET);
});