<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return redirect()->route('contacts.index');
});

Route::resource('contacts', ContactController::class)->except(['create', 'show', 'edit']);
// We might need a separate route for 'edit' to fetch JSON if we use modal, 
// or just use valid resource routes. 
// Since the user has a modal, we likely need an API-style 'show' or 'edit' that returns JSON.
Route::get('/contacts/{contact}/edit-data', [ContactController::class, 'editData'])->name('contacts.edit-data');

// Temporary Dev Login Route
Route::get('/login-dev', function () {
    $user = \App\Models\User::where('role', 'admin')->first();
    if (!$user) {
        return 'No admin user found. Did you seed correctly?';
    }
    \Illuminate\Support\Facades\Auth::login($user);
    return redirect()->route('contacts.index');
});