<?php

use App\Http\Controllers\Api\PicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('PIC')->group(function () {
    Route::post('/login', [PicController::class, 'login']);
    Route::post('/order', [PicController::class, 'storeOrder']);
    Route::get('/riwayat-order', [PicController::class, 'riwayatOrder']);
});
route::prefix('KURIR')->group(function () {
    // Tambahkan route untuk KURIR di sini
});
