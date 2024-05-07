<?php

use App\Http\Controllers\AuthorizationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::post('login', [AuthorizationController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::prefix('tasks')->group(function () {
        Route::get('/', [TaskController::class, 'index']);

        Route::post('/', [TaskController::class, 'store']);

        Route::put('{task}/complete', [TaskController::class, 'complete']);

        Route::patch('{task}', [TaskController::class, 'update']);

        Route::delete('{task}', [TaskController::class, 'destroy']);
    });
});
