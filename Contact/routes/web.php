<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CityController;

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/directory', [PublicController::class, 'directory'])->name('public.directory');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('contacts', ContactController::class);
    Route::resource('cities', CityController::class);
});

// Alias for dashboard
Route::get('/dashboard', function() {
    return redirect()->route('dashboard');
})->middleware('auth');

