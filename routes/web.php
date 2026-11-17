<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\DaftarServiceController;
use App\Http\Controllers\DataServiceController;
use App\Http\Controllers\PembayaranServiceController;
use App\Models\Pelanggan;
use App\Models\Kendaraan;
use App\Models\DaftarService;
use App\Models\PembayaranService;

Route::get('/', function () {
    $totalPelanggan   = Pelanggan::count();
    $totalKendaraan   = Kendaraan::count();
    $totalService     = DaftarService::count();
    $totalPendapatan  = PembayaranService::sum('jumlah_biaya');
    $recentServices   = DaftarService::with(['pelanggan', 'kendaraan'])->latest()->take(5)->get();

    return view('dashboard', compact(
        'totalPelanggan',
        'totalKendaraan',
        'totalService',
        'totalPendapatan',
        'recentServices'
    ));
})->name('dashboard');

Route::resource('pelanggan', PelangganController::class);
Route::resource('kendaraan', KendaraanController::class);
Route::resource('daftar-service', DaftarServiceController::class);
Route::resource('data-service', DataServiceController::class);
Route::resource('pembayaran-service', PembayaranServiceController::class);