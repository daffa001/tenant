<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\AdmloginController;
use App\Http\Controllers\Api\RegisterController;



Route::prefix('auth-user')->group(function(){
    Route::apiResource('/register',RegisterController::class);
    Route::apiResource('/login', LoginController::class);
});

Route::prefix('auth-admin')->group(function(){
    Route::apiResource('/login',AdmloginController::class);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

