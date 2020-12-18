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

Route::post('/email-verify', 'VerifyController@verifyEmail');
Route::get('/email-verify/resend', 'Auth\VerificationController@resendVerify')->name('resend');

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', 'AuthController@register');
    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::post('/forgot-password', 'Auth\ForgotPasswordController@sendPasswordResetLink');
    Route::post('/reset-password', 'Auth\ResetPasswordController@callResetPassword');
    
    Route::group(['middleware' => ['auth:api']], function () {
        Route::post('/me', 'AuthController@me');
        Route::post('/user', 'AuthController@updateUser');
        Route::post('/change/password', 'AuthController@changePassword');
        Route::post('/email/configure', 'AuthController@emailConfigure');
    });
});

Route::group(['middleware' => ['auth:api']], function () {
    // Users
    Route::get('/users', 'UsersController@getList');
    Route::put('/users/{id}', 'UsersController@updateUser');
    Route::delete('/users/{id}', 'UsersController@deleteUser');
    Route::post('/users/change-password', 'UsersController@changePassword');

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
    Route::post('/summons/send/{id}', 'SummonsController@sendSummonMessage');
    Route::post('/summons/voice/record', 'SummonsController@recordVoicemail');
    Route::post('/summons/voice/response', 'SummonsController@responseVoiceCall');
    Route::get('/summons/voice/save', 'SummonsController@saveVoicemail');    

    // Histories
    Route::get('/histories/{summon_id}', 'SummonsController@getHistories');

    // Calendar-Event
    Route::get('/events', 'EventsController@getList');
    Route::post('/events', 'EventsController@createEvent');
    Route::put('/events/{id}', 'EventsController@updateEvent');
    Route::post('/events/dragged/{id}', 'EventsController@draggedEvent');
    Route::delete('/events/{id}', 'EventsController@deleteEvent');
});
