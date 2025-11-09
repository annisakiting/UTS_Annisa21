<?php

use Illuminate\Support\Facades\Route;

// Controller APLIKASI KITA
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Halaman Publik (SEBELUM LOGIN)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Halaman Privat (SETELAH LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. ROUTE DASHBOARD STATISTIK
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. ROUTE PELANGGAN
    Route::resource('pelanggan', CustomerController::class);
    
    // 3. ROUTE LAYANAN
    Route::resource('layanan', ServiceController::class);
    
    // 4. ROUTE PESANAN
    Route::resource('pesanan', OrderController::class);

    // 5. ROUTE UKURAN
    Route::get('/pelanggan/{customer}/ukuran', [MeasurementController::class, 'index'])
         ->name('pelanggan.ukuran.index');
    Route::get('/pelanggan/{customer}/ukuran/create', [MeasurementController::class, 'create'])
         ->name('pelanggan.ukuran.create');
    Route::post('/pelanggan/{customer}/ukuran', [MeasurementController::class, 'store'])
          ->name('pelanggan.ukuran.store');
    Route::get('/ukuran/{measurement}/edit', [MeasurementController::class, 'edit'])
         ->name('ukuran.edit');
    Route::put('/ukuran/{measurement}', [MeasurementController::class, 'update'])
         ->name('ukuran.update');
    Route::delete('/ukuran/{measurement}', [MeasurementController::class, 'destroy'])
          ->name('ukuran.destroy');

});
// Akhir dari grup 'middleware'

// Ini adalah file yang berisi rute-rute login, register, logout, dll.
require __DIR__.'/auth.php';