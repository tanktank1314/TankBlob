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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/','App\AppController@home')->name('app.home');
Route::get('/help','App\AppController@help')->name('app.help');
Route::get('/about','App\AppController@about')->name('app.about');
Route::resource('/users','Users\UsersController');
Route::get('/login','Login\LoginController@create')->name('login');
Route::post('/login','Login\LoginController@store')->name('login');
Route::delete('/logout','Login\LoginController@destroy')->name('logout');