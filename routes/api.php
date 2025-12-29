<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenggunaRoleController;
use App\Http\Controllers\StokGudangController;
use App\Http\Controllers\StokTokoController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('token-login', [AuthController::class, 'tokenLogin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('pengguna', [AuthController::class, 'pengguna']);
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('pengguna', PenggunaController::class);

    Route::post('pengguna/role', [PenggunaRoleController::class, 'assignRole']);
    
    Route::apiResource('kategori', GudangController::class);
    Route::apiResource('produk', ProdukController::class);

    Route::apiResource('toko', TokoController::class);
    Route::apiResource('gudang', GudangController::class);

    Route::post('gudang/{gudang}/produk', [StokGudangController::class, 'attach']);
    Route::delete('gudang/{gudang}/produk/{produk}', [StokGudangController::class, 'detach']);
    Route::put('gudang/{gudang}/produk/{produk}', [StokGudangController::class, 'update']);

    Route::post('toko/{toko}/produk', [StokTokoController::class, 'store']);
    Route::put('toko/{toko}/produk/{produk}', [StokTokoController::class, 'update']);
    Route::delete('toko/{toko}/produk/{produk}', [StokTokoController::class, 'destroy']); 

    Route::apiResource('transaksi', TransaksiController::class);
});

Route::middleware(['auth:sanctum', 'role:admin|operator'])->group(function () {
    Route::get('kategori', [KategoriController::class, 'index']);
    Route::get('kategori/{kategori}', [KategoriController::class, 'show']);

    Route::get('produk', [ProdukController::class, 'index']);
    Route::get('produk/{produk}', [ProdukController::class, 'show']);

    Route::get('gudang', [GudangController::class, 'index']);
    Route::get('gudang/{gudang}', [GudangController::class, 'show']);

    Route::post('transaksi', [TransaksiController::class, 'store']);
    Route::get('transaksi/{transaksi}', [TransaksiController::class, 'show']);

    Route::get('my-toko', [TokoController::class, 'getMyTokoProfile']);
    Route::get('my-toko/transactions', [TransaksiController::class, 'getTransaksiByToko']);
});