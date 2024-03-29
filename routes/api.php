<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usercontroller;

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

// To access URL only by using token
Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::get('allUsers',[Usercontroller::class,'getAllUsers']);
    Route::get('logout',[Usercontroller::class,'logout']);
    Route::get('',function(){
        echo 'hi';  
    });

});

Route::post('register',[Usercontroller::class,'register']);
Route::post('login',[Usercontroller::class,'login']);