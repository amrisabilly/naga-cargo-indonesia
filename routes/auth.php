<?php

use App\Http\Controllers\Auth\AuthenticatedController;
use Illuminate\Support\Facades\Route;

// Route::post('/register', [AuthController::class, 'register'])->name('auth.register')->middleware('guest');
Route::get('/login', [AuthenticatedController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthenticatedController::class, 'authenticate'])->name('auth.authenticate');
// Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');
