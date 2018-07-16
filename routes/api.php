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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

#Read MailChimp lists
Route::get('/lists', 'MCListsController@index')->name('lists');

#Read MailChimp list
Route::get('/lists/{mclist}', 'MCListsController@show')->name('list');

#Create MailChimp list
Route::post('/lists', 'MCListsController@store');

#Update MailChimp list
Route::patch('/lists/{mclist}', 'MCListsController@update');

#Delete MailChimp list
Route::delete('/lists/{mclist}', 'MCListsController@destroy');

#Read all members from list
Route::get('/lists/{mclist}/members', 'MCListMembersController@index');

#Read particular member from list
Route::get('/lists/{mclist}/members/{subscriber_hash}', 'MCListMembersController@show');

#Create particular member from list
Route::post('/lists/{mclist}/members', 'MCListMembersController@store');

#Update particular member from list
Route::patch('/lists/{mclist}/members/{subscriber_hash}', 'MCListMembersController@update');

#Delete particular member from list
Route::delete('/lists/{mclist}/members/{subscriber_hash}', 'MCListMembersController@destro');
