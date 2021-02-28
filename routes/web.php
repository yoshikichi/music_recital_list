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
// 送信メール本文のプレビュー
Route::get('sample/mailable/preview', function () {
  return new App\Mail\RecitalPlanNotification();
});

Route::get('recitalplan/mailable/send/{admid?}', 'RecitalPlanSendController@RecitalPlanSend');
//Route::post('recitalplan/mailable/send', 'RecitalPlanSendController@RecitalPlanSend');
