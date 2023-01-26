<?php

use App\Http\Controllers\Api\PartTwo\Users\AuthController;
use App\Http\Controllers\Api\PartTwo\Users\EditProfileController;
use App\Http\Controllers\ِApi\PartOne\FirstTaskController;
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
//part one
//Q1
Route::post('/first_task',[FirstTaskController::class,'countOfAllNum']);
//q2
Route::post('/second_task',[FirstTaskController::class,'second_task']);


//part Two
Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/getUserById/{id}',[AuthController::class,'getUserById'])->middleware('checkUser:api');;
    Route::get('/getAllUsers',[AuthController::class,'getAllUsers'])->middleware('checkUser:api');;
    Route::delete('/deleteUserById/{id}',[AuthController::class,'deleteUser']);


    Route::post('/edit',[EditProfileController::class,'Editprofile'])->middleware('checkUser:api');
    Route::post('/change_password',[EditProfileController::class,'change_password'])->middleware('checkUser:api');
});


