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
header('Access-Control-Allow-Origin: *');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('jwt:auth');

Route::group(['middleware' => 'cors'], function () {
    //User
    Route::post('login', 'Auth\LoginController@login');

    Route::get('profile', 'Auth\LoginController@getAuthenticatedUser');
    Route::post('register', 'Auth\RegisterController@postRegister');
    Route::get('logout', 'Auth\LoginController@logout');

    //Edit user profile
    Route::put('profile/{id}', 'Auth\EditController@putUpdateProfile');

    //Create event
    Route::post('create_event', 'EventController@create');
});





