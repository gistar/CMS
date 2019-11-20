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
Route::redirect('/', '/admin', 301);

//Route::get('/', function () {
//    return view('welcome');
//});

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

//Route::group(['prefix' => '/admin', 'namespace' => 'Admin'],function(){
//    Route::get('/register', 'RegisterController@registershow')->name('register');
//    Route::post('/register', 'RegisterController@register');
//
//    Route::get('/login', 'LoginController@loginshow')->name('login');
//    Route::post('/login', 'LoginController@login');
//
//    Route::get('/dashBoard', 'DashBoardController@home')->name('dashBoard');
//});

