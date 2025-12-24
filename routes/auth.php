<?php

use App\Http\Controllers\Auth\AuthenticatedController;
use Illuminate\Support\Facades\Route;

// Route::post('/register', [AuthController::class, 'register'])->name('auth.register')->middleware('guest');
Route::get('/', [AuthenticatedController::class, 'login'])->name('auth.login')->middleware('guest');
Route::post('/login', [AuthenticatedController::class, 'authenticate'])->name('auth.authenticate')->middleware('guest');
Route::post('/logout', [AuthenticatedController::class, 'logout'])->name('auth.logout')->middleware('auth');
