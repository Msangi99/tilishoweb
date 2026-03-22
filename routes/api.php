<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiDashboardController;
use App\Http\Controllers\ApiParcelController;

// Public routes
Route::post('/login', [ApiAuthController::class, 'login']);

// Protected routes (require Sanctum token)
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::get('/user', [ApiAuthController::class, 'user']);
    Route::patch('/user', [ApiAuthController::class, 'updateProfile']);
    Route::post('/user/verify-password', [ApiAuthController::class, 'verifyPassword']);
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    
    // Dashboard route
    Route::get('/dashboard', [ApiDashboardController::class, 'stats']);
    
    // Parcel routes
    Route::get('/parcels/my', [ApiParcelController::class, 'myParcels']);
    Route::get('/parcels/view/{tracking_number}', [ApiParcelController::class, 'viewParcel']);
    Route::post('/parcels', [ApiParcelController::class, 'store']);
    Route::post('/parcels/scan', [ApiParcelController::class, 'scanParcel']);
    Route::post('/parcels/assign-transporter', [ApiParcelController::class, 'assignTransporter']);
    Route::post('/parcels/assign-receiver', [ApiParcelController::class, 'assignReceiver']);
    Route::get('/buses', [ApiParcelController::class, 'getBuses']);
    Route::get('/routes', [ApiParcelController::class, 'getRoutes']);
});
