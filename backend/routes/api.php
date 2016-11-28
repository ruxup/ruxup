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


Route::post('login', 'Auth\LoginController@login');
Route::get('login/profile', 'Auth\LoginController@getAuthenticatedUser');
Route::get('logout', 'Auth\LoginController@logout');

//Edit user profile
Route::get('/profile/{id}', 'Auth\EditController@getProfile');
Route::put('/profile/{id}', 'Auth\EditController@putUpdateProfile');

