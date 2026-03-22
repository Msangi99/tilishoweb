<?php

use App\Http\Controllers\ApiDashboardController;
use App\Http\Controllers\WebArtisanCommandController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Dashboard stats for web (session-authenticated)
Route::get('/dashboard/stats', [ApiDashboardController::class, 'stats'])
    ->middleware('auth')
    ->name('dashboard.stats');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->name('logout');

Route::prefix('command')
    ->middleware(['auth', 'admin', 'web.commands'])
    ->name('command.')
    ->group(function () {
        Route::get('/', [WebArtisanCommandController::class, 'index'])->name('index');
        Route::post('/migrate', [WebArtisanCommandController::class, 'migrate'])->name('migrate');
        Route::post('/migrate-fresh', [WebArtisanCommandController::class, 'migrateFresh'])->name('migrate-fresh');
        Route::post('/seed', [WebArtisanCommandController::class, 'seed'])->name('seed');
        Route::post('/optimize-clear', [WebArtisanCommandController::class, 'optimizeClear'])->name('optimize-clear');
        Route::post('/migrate-path', [WebArtisanCommandController::class, 'migratePath'])->name('migrate-path');
    });
