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

Route::get('/', 'HomeController@welcome')->name('welcome');
Route::get('/product/{product}', 'HomeController@product')->name('product');

Auth::routes();

Route::get('/home', 'HomeController@home')->name('home');

Route::get('/login/kakao', 'KakaoController@redirectToProvider')->name('login.kakao');
Route::get('/kakao_oauth', 'KakaoController@handleProviderCallback');

Route::middleware(['auth.admin'])->prefix('admin')->name('admin.')->group(function() {
	Route::get('/home', 'AdminController@home')->name('home');
});

Route::middleware(['auth.member'])->prefix('member')->name('member.')->group(function() {
	Route::get('/home', 'MemberController@home')->name('home');
});
