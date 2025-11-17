<?php

use App\Http\Controllers\api\KurirController;
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

Route::prefix('KURIR')->group(function () {
    Route::post('/login', [KurirController::class, 'login']);
    Route::get('/order-by-daerah', [KurirController::class, 'getOrderByDaerah']); // Baru
    Route::post('/search-order', [KurirController::class, 'searchOrder']);
    Route::post('/update-order', [KurirController::class, 'updateOrder']);
    Route::post('/upload-foto', [KurirController::class, 'uploadFoto']);
    Route::get('/riwayat-order', [KurirController::class, 'riwayatOrder']);
    Route::get('/detail-order/{AWB}', [KurirController::class, 'detailOrder']);
});
