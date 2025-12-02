<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KandangController;
use App\Http\Controllers\Api\LaporanHarianController;
use App\Http\Controllers\Api\StokPakanController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Kandang
    Route::apiResource('kandangs', KandangController::class);

    // Laporan Harian
    Route::get('laporan-harian', [LaporanHarianController::class, 'index']);
    Route::post('laporan-harian', [LaporanHarianController::class, 'store']);

    // Stok Pakan
    Route::get('stok-pakan', [StokPakanController::class, 'index']);
    Route::post('stok-pakan', [StokPakanController::class, 'store']);
    Route::post('stok-pakan/transaksi', [StokPakanController::class, 'addTransaction']);
});
