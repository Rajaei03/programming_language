<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;

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



//rajaei routes


Route::post('/login',[LoginController::class ,'login']);
Route::get('/home',[HomeController::class ,'home']);
Route::get('/home/{id}',[HomeController::class ,'homeFilter']);
Route::post('/registerExpert' , [RegisterController::class,'registerExpert']);




























//obada routes
Route::post('/registerUser' , [RegisterController::class,'registerUser']);
Route::get('/register' ,[RegisterController::class , 'index']);
Route::get('/profile/{id}',[ProfileController::class ,'profile']);
Route::get('/search/{name}',[HomeController::class ,'search']);
