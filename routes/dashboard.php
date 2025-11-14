<?php

use App\Http\Controllers\DaerahController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DataController;
use App\Http\Controllers\Dashboard\DataPengiriman;
use App\Http\Controllers\Dashboard\DataPicController;
use App\Http\Controllers\Dashboard\DataKurirController;

Route::get('/', [DataController::class, 'index'])->name('index');

Route::prefix('dashboard')->name('dashboard.')->group(function(){
    Route::get('/daerah', [DaerahController::class, 'index'])->name('daerah');
    Route::resource('/data-daerah', DaerahController::class);
    Route::get('/data-pengiriman/daerah/{id_daerah}', [DataPengiriman::class, 'showByDaerah'])->name('data-pengiriman.daerah');
    Route::resource('/data-pengiriman', DataPengiriman::class);
    Route::resource('/data-kurir', DataKurirController::class);
    Route::resource('/data-pic', DataPicController::class);
});
