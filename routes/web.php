<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiDashboardController;

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
