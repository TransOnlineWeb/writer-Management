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

Route::apiResources(['order' => 'API\OrderController']);
Route::get('profile','API\UserController@profile');
Route::put('profile','API\UserController@updateProfile');

Route::apiResources(['user' => 'API\UserController']);
Route::get('contacts','API\ContactsController@index');
Route::get('student','API\ContactsController@student');
Route::get('conversation/{id}','API\ContactsController@getMessagesFor');
Route::post('conversation/send','API\ContactsController@send');
Route::get('unread','API\ContactsController@index');
Route::apiResources(['/user' => 'API\UserController']);

Route::get('filescount/{orderId}', 'API\MoreOrdersController@filesCount');
Route::get('getfiles/{orderId}', 'API\MoreOrdersController@getFiles');
Route::get('download/{orderId}', 'API\MoreOrdersController@downloadFile');
Route::post('addfiles/{orderId}', 'API\MoreOrdersController@addFiles');
Route::get('getwriters', 'API\MoreOrdersController@getWriters');
