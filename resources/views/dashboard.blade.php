@extends('layouts.app')

@section('title', 'Dashboard - Service Motor App')
@section('page_title', 'Dashboard Ringkasan Bengkel')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100 border-start border-primary border-4">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Total Pelanggan</div>
                    <div class="fs-3 fw-bold text-dark mt-1">{{ $totalPelanggan }}</div>
                </div>
                <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card h-100 border-start border-success border-4">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Total Kendaraan</div>
                    <div class="fs-3 fw-bold text-dark mt-1">{{ $totalKendaraan }}</div>
                </div>
                <div class="bg-success bg-opacity-10 text-success rounded-3 p-3">
                    <i class="bi bi-bicycle fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card h-100 border-start border-warning border-4">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Total Pendaftaran Servis</div>
                    <div class="fs-3 fw-bold text-dark mt-1">{{ $totalService }}</div>
                </div>
                <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3">
                    <i class="bi bi-clipboard2-check-fill fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card h-100 border-start border-info border-4">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Total Pendapatan</div>
                    <div class="fs-4 fw-bold text-dark mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                </div>
                <div class="bg-info bg-opacity-10 text-info rounded-3 p-3">
                    <i class="bi bi-wallet2 fs-3"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2 text-primary"></i>5 Pendaftaran Service Terbaru</h6>
        <a href="{{ route('daftar-service.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID Servis</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>No. Plat & Jenis</th>
                        <th>Keluhan Kendaraan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentServices as $srv)
                        <tr>
                            <td class="ps-4 fw-semibold text-primary">{{ $srv->id_servis }}</td>
                            <td>{{ \Carbon\Carbon::parse($srv->tanggal_servis)->format('d/m/Y') }}</td>
                            <td>{{ $srv->pelanggan->nama_lengkap ?? '-' }} <span class="text-muted small">({{ $srv->id_pelanggan }})</span></td>
                            <td>
                                <span class="badge bg-dark">{{ $srv->no_plat }}</span>
                                <small class="text-muted ms-1">{{ $srv->kendaraan->jenis_kendaraan ?? '' }}</small>
                            </td>
                            <td>{{ $srv->keluhan_kendaraan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data pendaftaran service.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
