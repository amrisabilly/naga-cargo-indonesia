<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DataController;
use App\Http\Controllers\Dashboard\DataPengiriman;
use App\Http\Controllers\Dashboard\DataPicController;
use App\Http\Controllers\Dashboard\PenggunaController;

Route::get('/', [DataController::class, 'index'])->name('index');

Route::prefix('dashboard')->name('dashboard.')->group(function(){
    Route::resource('/data-pengiriman', DataPengiriman::class);
    Route::resource('/data-pengguna', PenggunaController::class);
    Route::resource('/data-pic', DataPicController::class);
});    
