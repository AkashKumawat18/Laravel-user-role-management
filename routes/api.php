<?php


use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\PermissionController;
use App\Http\Controllers\user\RoleController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

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


Route::post('login', [AuthController::class, 'login']);
Route::get('users/verify/{token}', [UserController::class, 'verify']);
Route::post('forgot-password', [UserController::class, 'forgot']);
Route::post('reset-password/{token}', [UserController::class, 'reset']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    // User's group
    Route::group([
        'namespace' => 'user',
        'prefix' => 'users',
    ], function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::get('/', [UserController::class, 'index']);
        Route::delete('/delete/{id}', [UserController::class, 'delete']);
        Route::patch('/{id}', [UserController::class, 'update']);
        Route::post('/{id}/logout', [AuthController::class, 'logout']);
    });

    // Role's Route
    Route::group([
        'namespace' => 'role',
        'prefix' => 'roles',
    ], function () {
        Route::post('/', [RoleController::class, 'create']);
        Route::delete('/{id}', [RoleController::class, 'delete']);
        Route::patch('/{id}', [RoleController::class, 'update']);
    });
});

//create a user through system user
