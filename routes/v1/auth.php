<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'guest'], function () {
    Route::post('/login', [\App\V1\API\Controllers\AuthController::class, 'login']);
    Route::post('/login/{code}', [\App\V1\API\Controllers\AuthController::class, 'verify']);
    Route::post('forgot-password', [\App\V1\API\Controllers\AuthController::class, 'forgotPass']);
    Route::post('/reset-password/{token}', [\App\V1\API\Controllers\AuthController::class, 'newPassword']);
});

Route::post('/logout', [\App\V1\API\Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');