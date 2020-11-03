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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

#頁面
//登入
Route::get('/bank', 'AccountsController@index');
//註冊
Route::get('/bank/signup', function () {
    return view('signup');
});
//主頁
Route::get('/bank/homepage', 'AccountInfoController@index');
// 存款
Route::get('/bank/deposit', 'AccountInfoController@deposit_page');
//提款
Route::get('/bank/withdrawal', 'AccountInfoController@withdrawal_page');
//登出
Route::get('/bank/logout', 'AccountsController@signout');


#功能
//登入
Route::post('/bank/login', 'AccountsController@login');
//註冊
Route::post('/bank/signup', 'AccountsController@signup');
//存款
Route::post('/bank/deposit', 'AccountInfoController@deposit');
//提款
Route::post('/bank/withdrawal', 'AccountInfoController@withdrawal');
//搜尋
Route::post('/bank/show', 'AccountInfoController@show');
