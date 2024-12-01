<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\Authentication;
use Illuminate\Support\Facades\Route;

Route::post('/login' , [UserController::class , 'login']);
Route::post('/register' , [UserController::class , 'register']);




Route::middleware([Authentication::class])->group(function(){
    Route::get('/my' , [UserController::class , 'index']);
    Route::get('/logout' , [UserController::class , 'logout']);
});
