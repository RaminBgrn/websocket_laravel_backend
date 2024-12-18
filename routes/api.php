<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\Authentication;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);



Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/user_data', [UserController::class, 'index']);
    Route::get('/all_users', [UserController::class, 'getAllUsers']);
});
