<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/register',[UserController::class,'register']);
Route::get('/login',[UserController::class,'login']);
Route::post('/saveregister',[UserController::class,'saveregister']);
Route::post('/savelogin',[UserController::class,'savelogin']);
Route::post('/forgetpassword',[UserController::class,'forget_password']);
Route::get('/all',[\App\Http\Controllers\SchoolController::class,'all']);
Route::post('/upload',[\App\Http\Controllers\SchoolController::class,'submit']);
//Route::get('register',['as'=>'register','uses'=>'UserController@register']);
//Route::post('saveregister',['as'=>'saveregister','uses'=>'UserController@saveregister']);
//Route::get('/allproduct',[\App\Http\Controllers\ProductController::class,'allproduct']);
//Route::get('/all-product',['as'=>'allproduct','uses'=>'ProductController@allproduct']);
Route::get('math',[\App\Http\Controllers\UserController::class,'math']);

Route::get('/product',[ProductController::class,'allproduct']);
Route::post('/saveproduct',[ProductController::class,'saveproduct']);
Route::get('/showproduct/{id}',[ProductController::class,'showproduct']);
Route::post('/updateproduct/{id}',[ProductController::class,'updateproduct']);
Route::delete('/deleteproduct/{id}',[ProductController::class,'deleteproduct']);
