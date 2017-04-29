<?php

use Illuminate\Http\Request;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('jwt:auth');

Route::group(['prefix' => 'user'], function (){
    Route::post('register', array('as' => 'user.register', 'uses' => 'Auth\RegisterController@Register'));
    Route::get('logout', array('as' => 'user.logout', 'uses' => 'Auth\LoginController@logout'));
    Route::get('events/{id}', array('as' => 'user.events', 'uses' => 'UserController@getEvents'));
    Route::post('rate', array('as' => 'user.rate', 'uses' => 'UserController@rate')); //under development
    Route::post('/', array('as' => 'user.login', 'uses' => 'Auth\LoginController@login'));
    Route::get('/', array('as' => 'user.profile', 'uses' => 'Auth\LoginController@getAuthenticatedUser'));
    Route::put('{id}', array('as' => 'user.update', 'uses' => 'Auth\EditController@putUpdateProfile')); //not tested
    Route::delete('{id}', array('as' => 'user.remove', 'uses' => 'UserController@removeProfile'));
    Route::get('{id}', array('as' => 'user.restore', 'uses' => 'UserController@restoreProfile'));
    Route::get('{userid}/{eventid}', array('as' => 'user.join', 'uses' => 'UserController@joinEvent'));
});

Route::group(['prefix' => 'admin'], function (){
    Route::post('change', array('as' => 'admin.change', 'uses' => 'UserController@changeOwner'));
    Route::get('{id}', array('as' => 'admin.events', 'uses' => 'UserController@getEventsWhereOwner'));
});

Route::group(['prefix' => 'password'], function() {
    Route::post('email',  array('as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@getResetToken'));
    Route::post('reset',  array('as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@reset'));
});

Route::group(['prefix' => 'event'], function (){
    Route::post('find',array('as' => 'event.find', 'uses' => 'UserController@findEvent'));
    Route::post('update', array('as' => 'event.update', 'uses' => 'EventController@updateEvent'));
    Route::get('restore/{id}', array('as' => 'event.restore', 'uses' => 'EventController@restoreEvent'));
    Route::post('/', array('as' => 'event', 'uses' => 'EventController@create'));
    Route::get('{id}', array('as' => 'event.dashboard', 'uses' => 'EventController@getEvent'));
    Route::delete('{id}', array('as' => 'event.remove', 'uses' => 'EventController@removeEvent'));
    Route::get('{columnNr}/{orderType}', array('as' => 'event.all', 'uses' => 'EventController@getAllEvents'));
    Route::delete('{userid}/{eventid}', array('as' => 'event.leave', 'uses' => 'EventController@leaveEvent'));
});

Route::group(['prefix' => 'members'], function (){
    Route::get('{id}', array('as' => 'event.members', 'uses' => 'EventController@getUsers'));
    Route::delete('{event_id}/{user_id}', array('as' => 'event.kick', 'uses' => 'EventController@kick')); //owner.
});

Route::group(['prefix' => 'messages'], function (){
    Route::post('/',  array('as' => 'message.send', 'uses' => 'MessageController@comment'));
    Route::delete('{id}/{owner_id}',  array('as' => 'message.delete', 'uses' => 'MessageController@delete'));
    Route::post('{id}/{owner_id}',  array('as' => 'message.edit', 'uses' => 'MessageController@edit'));
});

Route::group(['prefix' => 'interests'], function () {
    Route::post('/',  array('as' => 'interests.add', 'uses' => 'InterestsController@add'));
    Route::delete('{user_id}/{interest_id}',  array('as' => 'interests.remove', 'uses' => 'InterestsController@delete'));
});

//handle update;
//handle rate;
//handle images ->load images
//shorter address for api calls.
//chat one-on-one
//handle banned users.
//Setup ruxup email.

//handle invite another user to join event. - for Version 2.0
//handle pending/accept when user wants to join an event. - for Version 2.0
