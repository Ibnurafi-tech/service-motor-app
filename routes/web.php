<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\DaftarServiceController;
use App\Http\Controllers\DataServiceController;
use App\Http\Controllers\PembayaranServiceController;
use App\Models\Pelanggan;
use App\Models\Kendaraan;
use App\Models\DaftarService;
use App\Models\DataService;
use App\Models\PembayaranService;

Route::get('/', function () {
    $totalPelanggan   = Pelanggan::count();
    $totalKendaraan   = Kendaraan::count();
    $servisHariIni    = DaftarService::whereDate('tanggal_servis', today())->count();
    $totalService     = DaftarService::count();
    $totalTransaksi   = PembayaranService::count();
    $totalPendapatan  = PembayaranService::sum('jumlah_biaya');

    $recentServices   = DaftarService::with(['pelanggan', 'kendaraan', 'dataServices', 'pembayaranServices'])
        ->latest()
        ->take(6)
        ->get();

    $statusMenunggu   = DaftarService::doesntHave('dataServices')->count();
    $statusDikerjakan = DaftarService::has('dataServices')->doesntHave('pembayaranServices')->count();
    $statusSelesai    = DaftarService::has('pembayaranServices')->count();

    return view('dashboard', compact(
        'totalPelanggan',
        'totalKendaraan',
        'servisHariIni',
        'totalService',
        'totalTransaksi',
        'totalPendapatan',
        'recentServices',
        'statusMenunggu',
        'statusDikerjakan',
        'statusSelesai'
    ));
})->name('dashboard');

Route::resource('pelanggan', PelangganController::class);
Route::resource('kendaraan', KendaraanController::class);
Route::resource('daftar-service', DaftarServiceController::class);
Route::resource('data-service', DataServiceController::class);
Route::resource('pembayaran-service', PembayaranServiceController::class);

// Halaman Detail Servis Terpadu
Route::get('/detail-servis/{id_servis}', function ($id_servis) {
    $servis = DaftarService::with(['pelanggan', 'kendaraan', 'dataServices', 'pembayaranServices'])
        ->findOrFail($id_servis);

    return view('detail_servis.show', compact('servis'));
})->name('detail-servis.show');

// Halaman Profil & Pengaturan
Route::get('/profil', function () {
    return view('profil.index');
})->name('profil.index');

Route::post('/profil', function (Request $request) {
    $validated = $request->validate([
        'name'          => 'required|string|max:100',
        'email'         => 'required|email|max:100',
        'role'          => 'required|string|max:60',
        'phone'         => 'nullable|string|max:20',
        'workshop_name' => 'required|string|max:100',
        'workshop_addr' => 'nullable|string|max:255',
    ]);

    session(['mc_user' => $validated]);

    return redirect()->route('profil.index')->with('success', 'Profil & pengaturan bengkel berhasil diperbarui!');
})->name('profil.update');

Route::post('/profil/logout', function (Request $request) {
    $request->session()->forget('mc_user');
    return redirect()->route('dashboard')->with('success', 'Sesi akun berhasil di-reset ke default.');
})->name('profil.logout');
