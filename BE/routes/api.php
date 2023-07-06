<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\Api\UserController;
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

Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
});

Route::apiResource('todos', TodoController::class)->middleware(['auth:api']);
Route::apiResource('users', UserController::class)->middleware(['auth:api']);

Route::group(['prefix' => 'todos', 'middleware' => ['auth:api']], function () {
    Route::post('assign-user', [TodoController::class, 'assignTodoToUser']);
    Route::post('change-status', [TodoController::class, 'changeStatusTodo']);
});
