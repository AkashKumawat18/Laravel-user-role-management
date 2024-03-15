<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::get('users/verify/{token}',[UserController::class,'verify']);
Route::post('forgot-password',[UserController::class,'forgot']);
Route::post('reset-password/{token}',[UserController::class,'reset']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    // User's group
    Route::group([
        'namespace' => 'user',
        'prefix' => 'users',
    ], function(){
        Route::get('/',[UserController::class,'index']);
        Route::delete('/delete/{id}',[UserController::class,'delete']);
        Route::patch('{id}', [UserController::class,'update']);
        Route::post('{id}/logout',[AuthController::class,'logout']);
    });
});



