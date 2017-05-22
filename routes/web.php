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

//欢迎界面
Route::get('/', function () {
    return view('welcome');
});

//用户认证服务
Auth::routes();

//主页
Route::get('/home', 'HomeController@index')->name('home');

//发送邮件
Route::get('/email/verify/{token}',['as'=>'email.verify','uses'=>'EmailController@verify']);

//提问
Route::resource('questions','QuestionsController');

//测试
Route::get('/test',"HomeController@test")->name('test');