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
Route::resource('/statuses','Statuses\StatusesController',['only' => ['store','destroy']]);
Route::get('/users/{user}/followings','Users\UsersController@followings')->name('users.followings');
Route::get('/users/{user}/followers','Users\UsersController@followers')->name('users.followers');
Route::post('/users/followers/{user}','Users\Followers\FollowersController@store')->name('followers.store');
Route::delete('/users/followers/{user}','Users\Followers\FollowersController@destroy')->name('followers.destroy');
Route::get('/login/confirm/{token}','Users\UsersController@confirmEmail')->name('confirm_email');