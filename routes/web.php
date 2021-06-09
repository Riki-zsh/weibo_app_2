<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/',"StaticPageController@home")->name('home');
Route::get('/help','StaticPageController@help')->name('help');
Route::get('/about',"StaticPageController@about")->name('about');

//UserController
Route::get('signup',"UserController@create")->name('signup');
Route::resource('user','UserController');
Route::get('login','SessionController@create')->name('login');//登录页面
Route::post('login','SessionController@store')->name('login');//登录请求(创建新会话)
Route::delete('logout','SessionController@destroy')->name('logout');//退出登录(销毁会话)
