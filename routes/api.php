<?php

use App\Http\Controllers\UserController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login' , [UserController::class , 'store'])->name('user-login');

Route::middleware([Authenticate::class])->group([
    Route::get('/user_data' , [UserController::class , 'index']),
]);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
