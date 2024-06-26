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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'v1','namespace'=>'App\Http\Controllers\Api\V1'],function(){
    Route::post('register',['uses'=>'AuthController@store']);
    Route::post('login',['uses'=>'AuthController@login']);
});
Route::group(['prefix'=>'v1','namespace'=>'App\Http\Controllers\Api\V1','middleware'=>'auth:sanctum'],function(){
    Route::apiResource('customers',CustomerController::class);
    Route::apiResource('invoices',InvoiceController::class);
    Route::post('invoices/bulk',['uses'=>'InvoiceController@bulkStore']);
    Route::post('logout',['uses'=>'AuthController@logout']);
});