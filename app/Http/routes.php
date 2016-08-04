<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth(); // Add routes for login/register/logout

/******************* Registered User Routes ***********************/
Route::get('/home', 'HomeController@index');
Route::get('/home/opened/{poll}', 'PollsController@index');
Route::post('/home/opened/{poll}', 'PollsController@answer');
Route::get('/home/closed/{poll}', 'PollsController@show_result');
Route::get('/account', 'HomeController@account_info');
Route::put('/account/password', 'HomeController@change_password');
Route::put('/account/email', 'HomeController@change_email');

/**************************** Admin Routes *************************/
Route::get('/admin', 'AdminController@index');
Route::get('/admin/{poll}', 'AdminController@modify_poll_view');
Route::post('/admin/poll/new', 'AdminController@create_poll');
Route::post('/admin/question/new', 'AdminController@create_question');
Route::post('/admin/option/new', 'AdminController@create_option');
Route::put('/admin/poll/{poll}', 'AdminController@modify_poll');
Route::put('/admin/question/{question}', 'AdminController@modify_question');
Route::put('/admin/option/{option}', 'AdminController@modify_option');
Route::delete('/admin/poll/{poll}', 'AdminController@delete_poll');
Route::delete('/admin/question/{question}', 'AdminController@delete_question');
Route::delete('/admin/option/{option}', 'AdminController@delete_option');
