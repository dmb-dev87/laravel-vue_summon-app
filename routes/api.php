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
    Route::get('/users', 'UsersController@getList');
    Route::put('/users/{id}', 'UsersController@updateUser');
    Route::delete('/users/{id}', 'UsersController@deleteUser');

    // Location
    Route::get('/locations', 'LocationsController@getList');
    Route::post('/locations', 'LocationsController@createLocation');
    Route::put('/locations/{id}', 'LocationsController@updateLocation');
    Route::delete('/locations/{id}', 'LocationsController@deleteLocation');

    // Groups
    Route::get('/groups', 'GroupsController@getList');
    Route::delete('/groups/{id}', 'GroupsController@deleteGroup');
    Route::put('/groups/{id}', 'GroupsController@updateGroup');
    Route::post('/groups', 'GroupsController@createGroup');

    // Contacts
    Route::get('/contacts', 'ContactsController@getList');
    Route::delete('/contacts/{id}', 'ContactsController@deleteContact');
    Route::post('/contacts', 'ContactsController@createContact');
    Route::put('/contacts/{id}', 'ContactsController@updateContact');

    // Summons
    Route::get('/summons', 'SummonsController@getList');
    Route::get('/summons/location_options', 'SummonsController@getLocationOptions');
    Route::get('/summons/group_options', 'SummonsController@getGroupOptions');
    Route::get('/summons/contact_options', 'SummonsController@getContactOptions');
    Route::post('/summons', 'SummonsController@createSummon');

    // Calendar-Event
    Route::get('/events', 'EventsController@getList');
    Route::post('/events', 'EventsController@createEvent');
    Route::put('/events/{id}', 'EventsController@updateEvent');
    Route::post('/events/dragged/{id}', 'EventsController@draggedEvent');
    Route::delete('/events/{id}', 'EventsController@deleteEvent');
});
