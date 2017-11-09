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

use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/test', function(\App\Services\UserMatchSaverInterface $userMatch){
	$userMatch->saveMatchesForUser();
});

Route::get('/rest', function(\App\Services\MatchGeneratorInterface $allMatch){
	dd($allMatch->compileMatchMap()->saveMatchMap());
});