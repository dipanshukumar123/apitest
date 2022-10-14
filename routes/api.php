<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:api')->group(function (){
//    Route::get('/profile',[UserController::class,'profile']);
    Route::get('/product',[ProductController::class,'allproduct']);
    Route::post('/saveproduct',[ProductController::class,'saveproduct']);
    Route::get('/showproduct/{id}',[ProductController::class,'showproduct']);
    Route::post('/updateproduct/{id}',[ProductController::class,'updateproduct']);
    Route::delete('/deleteproduct/{id}',[ProductController::class,'deleteproduct']);
    Route::get('/searchproduct/{name}',[ProductController::class,'searchproduct']);
    Route::post('/statusproduct/{id}',[ProductController::class,'Status']);
});
Route::post('/savelogin',[UserController::class,'savelogin']);
Route::post('/saveregister',[UserController::class,'saveregister']);

Route::post('/forgetpassword',[UserController::class,'forget_password']);

Route::middleware('auth:api')->group(function (){


//    Route::get('/profile',[UserController::class,'profile']);
    Route::post('/updatepassword/{id}',[UserController::class,'updatepassword']);
    Route::post('/resetpassword/{id}',[UserController::class,'reset_password'])->name('resetpassword');
});

