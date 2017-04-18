<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('jwt:auth');

//User
Route::post('login', 'Auth\LoginController@login');
Route::get('profile', 'Auth\LoginController@getAuthenticatedUser');
Route::post('register', 'Auth\RegisterController@postRegister');
Route::get('logout', 'Auth\LoginController@logout');
Route::get('getEvents/{id}', 'UserController@getEvents');
Route::get('getEventsOwner/{id}', 'UserController@getEventsWhereOwner');
Route::get('joinEvent/{userid}/{eventid}', 'UserController@joinEvent');
Route::put('profile/{id}', 'Auth\EditController@putUpdateProfile');
Route::delete('removeProfile/{id}', 'UserController@removeProfile'); //messages, interestuser, rating
Route::get('restoreProfile/{id}', 'UserController@restoreProfile');
Route::post('rate', 'UserController@rate'); //under development
//handle registration/password reset/update;

//Event
Route::post('create_event', 'EventController@create');
Route::get('getUsers/{id}', 'EventController@getUsers');
Route::post('updateEvent', 'EventController@updateEvent');
Route::get('getAllEvents/{columnNr}/{orderType}', 'EventController@getAllEvents');
Route::delete('leaveEvent/{userid}/{eventid}', 'EventController@leaveEvent');
Route::post('findEvent','UserController@findEvent');
Route::delete('removeEvent/{id}', 'EventController@removeEvent'); //messages
Route::get('restoreEvent/{id}', 'EventController@restoreEvent');

//Message
Route::post('comment', 'MessageController@comment');






