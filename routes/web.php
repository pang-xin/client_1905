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

Route::get('/', function () {
    return view('welcome');
});

Route::get('api/test', 'TestController@test');
Route::get('api/encrypt', 'TestController@encrypt');

Route::get('api/rsa1', 'TestController@rsa1');

Route::get('api/curl1', 'TestController@curl1');
Route::get('api/curl2', 'TestController@curl2');
Route::get('api/curl3', 'TestController@curl3');
Route::get('api/curl4', 'TestController@curl4');


Route::get('api/sign1', 'TestController@sign1');
Route::get('api/sign2', 'TestController@sign2');


Route::get('user/addKey', 'UserController@addKey');
Route::post('user/addKey_do', 'UserController@addKey_do');
Route::get('user/decrypt', 'UserController@decrypt');
Route::post('user/decrypt_do', 'UserController@decrypt_do');
Route::get('user/sign', 'UserController@sign');
Route::post('user/sign_do', 'UserController@sign_do');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
