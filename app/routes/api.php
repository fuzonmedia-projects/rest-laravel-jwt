<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
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

Route::post('login',[UserController::class,'authenticate']);
Route::post('register',[UserController::class,'RegisterUser']);

Route::group(['middleware'=>['jwtauth']],function(){

    //Route::get('me',[UserController::class,'me']);
    Route::post('orders',[ProductController::class,'create']);
    Route::delete('orders/{id}',[ProductController::class,'delete']);
    Route::post('orders/{id}',[ProductController::class,'update']);
    Route::get('orders',[ProductController::class,'getall']);
    Route::get('orders/{id}',[ProductController::class,'getone']);
});


//Route::post('orders',[ProductController::class,'show']);



