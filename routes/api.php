<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::get('refresh', 'AuthController@refresh');    
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('me', 'AuthController@me');
    // Users
    Route::get('/users', 'UsersController@get');
    Route::put('/users/{id}', 'UsersController@updateUser');
    Route::delete('/users/{id}', 'UsersController@deleteUser');

    // Location
    Route::get('/locations', 'LocationsController@get');
    Route::post('/locations', 'LocationsController@createLocation');
    Route::put('/locations/{id}', 'LocationsController@updateLocation');
    Route::delete('/locations/{id}', 'LocationsController@deleteLocation');

    // Groups
    Route::get('/groups', 'GroupsController@get');
    Route::delete('/groups/{id}', 'GroupsController@deleteGroup');
    Route::put('/groups/{id}', 'GroupsController@updateGroup');
    Route::post('/groups', 'GroupsController@createGroup');

    // Contacts
    Route::get('/contacts', 'ContactsController@get');
    Route::delete('/contacts/{id}', 'ContactsController@deleteContact');
    Route::post('/contacts', 'ContactsController@createContact');
    Route::put('/contacts/{id}', 'ContactsController@updateContact');
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
