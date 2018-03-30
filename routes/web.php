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

Route::get('/redirect', 'HomeController@redirect')->name('redirect');

Route::get('/login/kakao', 'KakaoController@redirectToProvider')->name('login.kakao');
Route::get('/kakao_oauth', 'KakaoController@handleProviderCallback');

Route::post('/error-logs', 'ErrorLogController@store')->name('error-logs.store');

Route::middleware(['auth.member'])->prefix('/member')->name('member.')->group(function() {
	Route::get('/home', 'MemberController@home')->name('home');
});

Route::middleware(['auth.admin'])->prefix('/admin')->name('admin.')->group(function() {
	Route::get('/', 'AdminController@index');
	Route::get('/home', 'AdminController@home')->name('home');

	Route::prefix('/products')->name('products.')->group(function() {
		Route::get('/list', 'ProductController@dataList')->name('list');
		Route::get('/reset/list', 'ProductController@resetList')->name('reset.list');
		Route::post('/set/session', 'ProductController@setSessionPost')->name('set.session');
		Route::post('/{product}/activate', 'ProductController@activatePost')->name('activate');
	});
	Route::resource('/products', 'ProductController');

	Route::prefix('/error-logs')->name('error-logs.')->group(function() {
		Route::get('/list', 'ErrorLogController@dataList')->name('list');
		Route::get('/reset/list', 'ErrorLogController@resetList')->name('reset.list');
		Route::post('/set/session', 'ErrorLogController@setSessionPost')->name('set.session');
	});
	Route::resource('/error-logs', 'ErrorLogController', ['only' => [ 'index', 'show', 'update']]);
});
