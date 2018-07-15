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
Route::get('/lists/{list_id}', 'MCListsController@show')->name('list');

#Create MailChimp list
Route::post('/lists', 'MCListsController@store');

#Update MailChimp list
Route::patch('/lists/{list_id}', 'MCListsController@update');

#Delete MailChimp list
Route::delete('/lists/{list_id}', 'MCListsController@destroy');

#Read all members from list
Route::get('/lists/{list_id}/members', 'MCListMembersController@index');

#Read particular member from list
Route::get('/lists/{list_id}/members/{subscriber_hash}', 'MCListMembersController@show');

#Create particular member from list
Route::post('/lists/{list_id}/members', 'MCListMembersController@store');

#Update particular member from list
Route::patch('/lists/{list_id}/members/{subscriber_hash}', 'MCListMembersController@update');

#Delete particular member from list
Route::delete('/lists/{list_id}/members/{subscriber_hash}', 'MCListMembersController@destro');
