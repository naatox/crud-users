<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\AuthController;

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'all']);
    Route::get('/{mail}', [UserController::class, 'get']);
    Route::put('/{mail}', [UserController::class, 'update']);
    Route::delete('/{mail}', [UserController::class, 'delete']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/register', [AuthController::class, 'register']);
