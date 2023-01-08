<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SearchByNameController;

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

Route::get('/profile/{id}',[ProfileController::class ,'profile']);



Route::middleware('auth:sanctum')->post('/reserve' , [ReservationController::class,'reserve']);
Route::middleware('auth:sanctum')->get('/history',[ReservationController::class ,'history']);

Route::middleware('auth:sanctum')->get('/myProfile',[ProfileController::class ,'myProfile']);
Route::middleware('auth:sanctum')->post('/rate',[ProfileController::class ,'rate']);

Route::middleware('auth:sanctum')->post('/logout',[LoginController::class ,'logout']);


Route::middleware('auth:sanctum')->post('/createChat',[ChatController::class ,'createChat']);
Route::middleware('auth:sanctum')->get('/getChat',[ChatController::class ,'getChat']);

Route::middleware('auth:sanctum')->get('/getMessages/{chat_id}',[ChatController::class ,'getMessage']);
Route::middleware('auth:sanctum')->post('/createMessages',[ChatController::class ,'createMessage']);




























//obada routes
Route::post('/registerUser' , [RegisterController::class,'registerUser']);
//Route::post('/registerExpertphoto' , [RegisterController::class,'registerExpertPhoto']);
Route::get('/register' ,[RegisterController::class , 'index']);
Route::get('/search/{name}',[SearchController::class ,'search']);
Route::get('/searchbyname/{nameofexpert}',[SearchByNameController::class ,'searchbyname']);
Route::get('/experience/{id}',[CardController::class ,'card']);
Route::middleware('auth:sanctum')->post('/changefavourites' , [FavoriteController::class,'favorite']);
Route::middleware('auth:sanctum')->get('/showfavourites' , [FavoriteController::class,'showfavorite']);
Route::middleware('auth:sanctum')->get('/homewithtoken',[HomeController::class ,'homewithtoken']);
Route::middleware('auth:sanctum')->get('/homewithtoken/{id}',[HomeController::class ,'homeFilterwithroken']);
Route::middleware('auth:sanctum')->post('/registerExpertphoto' , [RegisterController::class,'registerExpertPhoto']);


