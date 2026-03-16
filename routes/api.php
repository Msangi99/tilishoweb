<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiDashboardController;

// Public routes
Route::post('/login', [ApiAuthController::class, 'login']);

// Protected routes (require Sanctum token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [ApiAuthController::class, 'user']);
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    Route::get('/dashboard', [ApiDashboardController::class, 'stats']);
});
