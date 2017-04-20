<?php

use Illuminate\Http\Request;

//Create local DB.
//Setup ruxup email.

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('jwt:auth');

//User
Route::post('login', 'Auth\LoginController@login');
Route::get('profile', 'Auth\LoginController@getAuthenticatedUser');
Route::post('register', 'Auth\RegisterController@postRegister'); //not tested
Route::get('logout', 'Auth\LoginController@logout');
Route::get('getEvents/{id}', 'UserController@getEvents');
Route::get('getEventsOwner/{id}', 'UserController@getEventsWhereOwner');
Route::get('joinEvent/{userid}/{eventid}', 'UserController@joinEvent');
Route::put('profile/{id}', 'Auth\EditController@putUpdateProfile'); //not tested
Route::delete('removeProfile/{id}', 'UserController@removeProfile');
Route::get('restoreProfile/{id}', 'UserController@restoreProfile');
Route::post('changeOwner', 'UserController@changeOwner'); //available only to owner
Route::post('rate', 'UserController@rate'); //under development
//handle registration/password reset/update;


//handle invite another user to join event. - for Version 2.0
//handle pending/accept when user wants to join an event. - for Version 2.0


//Event
Route::post('create_event', 'EventController@create');
Route::get('getUsers/{id}', 'EventController@getUsers');
Route::post('updateEvent', 'EventController@updateEvent');
Route::get('getAllEvents/{columnNr}/{orderType}', 'EventController@getAllEvents');
Route::delete('leaveEvent/{userid}/{eventid}', 'EventController@leaveEvent');
Route::post('findEvent','UserController@findEvent');
Route::delete('removeEvent/{id}', 'EventController@removeEvent');
Route::get('restoreEvent/{id}', 'EventController@restoreEvent');
Route::delete('kickMember/{event_id}/{user_id}', 'EventController@kick'); //available only to owner.
//handle banned users.

//Message
Route::post('comment', 'MessageController@comment');
Route::delete('deleteMessage/{id}/{owner_id}', 'MessageController@delete');
Route::post('editMessage/{id}/{owner_id}', 'MessageController@edit');

//Interests
Route::post('addInterest', 'InterestsController@add');
Route::delete('deleteInterest/{user_id}/{interest_id}', 'InterestsController@delete');

//shorter address for api calls.


