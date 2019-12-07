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

Route::post('/wallets/create', 'Api\WalletController@create');
Route::get('/wallets/balance', 'Api\WalletController@balance');
Route::post('/wallets/change-balance', 'Api\WalletController@changeBalance');

