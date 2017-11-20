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
    return view('index');
});
Route::any('/server-sent', 'HomeController@sent');
Route::any('/webhooks', 'HomeController@webhooks');
Route::any('/webhooks/test', 'HomeController@webhooksTest');
Route::any('/send-issue', 'HomeController@webhooksTest');
Route::any('/pusher_test', 'HomeController@pusher_test');
Route::any('/get', 'HomeController@getAllIssue');
Route::any('/getVoice', 'HomeController@sendVoice');
Route::any('/buildEventPusher', 'HomeController@buildEventPusher');
Route::any('/doneIssueChecked', 'HomeController@doneIssueChecked');