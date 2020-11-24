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
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group(['middleware' => ['api']], function () {
    // Users
    Route::get('/users', 'UsersController@get');

    // Location
    Route::get('/locations', 'LocationsController@get');

    // Groups
    Route::get('/groups', 'GroupsController@get');

    // Contacts
    Route::get('/contacts/{user_id}', 'ContactsController@get');
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
