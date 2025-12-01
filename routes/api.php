<?php

use App\Http\Controllers\GudangController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TokoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['role:admin'])->group(function () {
    Route::apiResource('produk', ProdukController::class);
    Route::apiResource('gudang', GudangController::class);
    Route::apiResource('toko', TokoController::class);
    Route::apiResource('pengguna', PenggunaController::class);
});

Route::middleware(['role:operator'])->group(function () {
    Route::post('/transaksi', [TransaksiController::class, 'store']);
});