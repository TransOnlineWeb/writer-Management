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
Route::post('uploadcomplete/{orderId}', 'API\MoreOrdersController@uploadCompleted');
Route::post('uploadedited/{orderId}', 'API\MoreOrdersController@uploadEdited');
Route::get('getcompleted/{orderId}', 'API\MoreOrdersController@getCompletedFiles');
Route::get('getedited/{orderId}', 'API\MoreOrdersController@getEditedFiles');

Route::get('MyWriters','API\RatingController@index');

Route::apiResources(['category' => 'API\WriterCategoryController']);

Route::apiResources(['rating' => 'API\RatingController']);
Route::get('rate/{orderId}','API\RatingController@getRate');
Route::get('myRate/{orderId}', 'API\RatingController@getMyRate');
Route::get('writer/{orderId}', 'API\MoreOrdersController@getWriter');
Route::get('deadline/{orderId}', 'API\MoreOrdersController@deadline');
Route::get('getcompleted', 'API\MoreOrdersController@getCompleted');
Route::get('getrevision', 'API\MoreOrdersController@getRevision');
Route::get('getedited', 'API\MoreOrdersController@getEdited');
Route::get('wallet', 'API\WalletTransactionsController@walletBalance');
Route::get('transactions', 'API\WalletTransactionsController@showTransactions');

Route::apiResources(['bid' => 'API\BidsController']);

Route::post('makebid/{orderId}','API\BidsController@makeBid');
Route::get('checkbid/{orderId}','API\BidsController@checkBid');

Route::apiResources(['Announcement' => 'API\AnnouncementController']);
Route::get('announce','API\AnnouncementController@announce');

Route::get('myorders','API\OrderController@getMyOrders');

Route::apiResources(['messenger'=>'API\MessangerController']);
Route::post('messenger/send','API\MessangerController@send');
Route::get('receiver','API\MessangerController@index');
Route::get('getMessage/{orderId}','API\MessangerController@getMessagesFor');

Route::get('getUser/{orderId}','API\OrderController@user');
Route::get('getAdmin','API\OrderController@admin');
Route::get('getMessage/{orderId}','API\MessangerController@getMessagesFor');

Route::post('verify_task/{orderId}','API\WalletTransactionsController@isVerified');

Route::get('earnings','API\PaymentController@index');
Route::get('myearnings/{userId}','API\PaymentController@myearnings');

Route::post('fine','API\WalletTransactionsController@fine');
Route::post('pay','API\WalletTransactionsController@pay');

Route::get('getLevel','API\UserController@getLevel');
Route::get('dashboard','API\DashboardController@index');
Route::get('myDashboard/{id}','API\DashboardController@myDashboard');
