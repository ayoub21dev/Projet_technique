<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CityController;

// Public
Route::get('/', [PublicController::class, 'index'])->name('home');

// Auth (guests only)
// Auth routes removed for local dev
// Auth (guests only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin
Route::prefix('admin')->middleware(['auth', 'can:access-admin'])->group(function () {
    Route::get('/', function() { return redirect()->route('contacts.index'); });
    Route::resource('contacts', ContactController::class)->except(['create', 'show']);
    Route::resource('cities', CityController::class)->only(['index', 'store', 'destroy']);
});

// Dashboard redirect
Route::redirect('/dashboard', '/admin/contacts');
Route::redirect('/admin/dashboard', '/admin/contacts');
Route::redirect('/admin', '/admin/contacts');
