<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\Authentication;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login' , [UserController::class , 'login']);
Route::post('/register' , [UserController::class , 'register']);




Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/logout' , [UserController::class , 'logout']);
});
