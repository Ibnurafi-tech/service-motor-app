@extends('layouts.app')

@section('title', 'Dashboard - MotorCare')
@section('page_title', 'Dashboard Operasional Bengkel')
@section('page_subtitle', 'Ringkasan aktivitas servis, pelanggan, kendaraan, dan transaksi pembayaran')

@section('content')
<!-- KPI Summary Cards -->
<div class="row g-3 g-md-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-secondary small fw-semibold text-uppercase mb-1">Total Pelanggan</div>
                    <div class="fs-2 fw-bold text-mc-navy">{{ $totalPelanggan }}</div>
                    <div class="small text-muted mt-1"><i class="bi bi-person-check text-success me-1"></i>Terdaftar aktif</div>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; background-color: #DBEAFE; color: var(--mc-navy);">
                    <i class="bi bi-people-fill fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-secondary small fw-semibold text-uppercase mb-1">Total Kendaraan</div>
                    <div class="fs-2 fw-bold text-mc-navy">{{ $totalKendaraan }}</div>
                    <div class="small text-muted mt-1"><i class="bi bi-bicycle text-mc-orange me-1"></i>Unit tercatat</div>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; background-color: #FFEDD5; color: var(--mc-orange);">
                    <i class="bi bi-bicycle fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-secondary small fw-semibold text-uppercase mb-1">Servis Hari Ini</div>
                    <div class="fs-2 fw-bold text-mc-navy">{{ $servisHariIni }}</div>
                    <div class="small text-muted mt-1">Dari total <span class="fw-semibold text-dark">{{ $totalService }}</span> pendaftaran</div>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; background-color: #FEF3C7; color: #B45309;">
                    <i class="bi bi-wrench-adjustable fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card h-100">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-secondary small fw-semibold text-uppercase mb-1">Transaksi Pembayaran</div>
                    <div class="fs-4 fw-bold text-mc-navy">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                    <div class="small text-muted mt-1"><span class="fw-semibold text-success">{{ $totalTransaksi }}</span> transaksi lunas</div>
                </div>
                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; background-color: #DCFCE7; color: #15803D;">
                    <i class="bi bi-cash-stack fs-4"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Servis Kendaraan & Aksi Cepat -->
<div class="row g-3 g-md-4 mb-4">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header py-3 px-4 d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold text-mc-navy"><i class="bi bi-activity me-2 text-mc-orange"></i>Status Servis Kendaraan</h6>
                <span class="small text-muted">Pemantauan alur bengkel</span>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 border bg-light h-100">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge badge-soft-warning px-2.5 py-1">Menunggu Mekanik</span>
                                <i class="bi bi-hourglass-split text-warning fs-5"></i>
                            </div>
                            <div class="fs-3 fw-bold text-mc-navy">{{ $statusMenunggu }}</div>
                            <div class="small text-secondary">Terdaftar, belum masuk pengerjaan</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 border bg-light h-100">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge badge-soft-navy px-2.5 py-1">Sedang Dikerjakan</span>
                                <i class="bi bi-gear-fill text-mc-navy fs-5"></i>
                            </div>
                            <div class="fs-3 fw-bold text-mc-navy">{{ $statusDikerjakan }}</div>
                            <div class="small text-secondary">Ditangani mekanik, menunggu bayar</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 border bg-light h-100">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge badge-soft-success px-2.5 py-1">Selesai & Lunas</span>
                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                            </div>
                            <div class="fs-3 fw-bold text-mc-navy">{{ $statusSelesai }}</div>
                            <div class="small text-secondary">Servis rampung & terbayar</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header py-3 px-4">
                <h6 class="mb-0 fw-bold text-mc-navy"><i class="bi bi-lightning-charge-fill me-2 text-mc-orange"></i>Aksi Cepat Operasional</h6>
            </div>
            <div class="card-body p-4 d-flex flex-column justify-content-between gap-2">
                <a href="{{ route('daftar-service.index') }}" class="btn btn-mc-orange w-100 text-start d-flex align-items-center justify-content-between py-2.5 px-3">
                    <span><i class="bi bi-clipboard2-plus-fill me-2"></i>Pendaftaran Servis Baru</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
                <a href="{{ route('data-service.index') }}" class="btn btn-outline-secondary w-100 text-start d-flex align-items-center justify-content-between py-2 px-3">
                    <span><i class="bi bi-wrench-adjustable-circle me-2 text-mc-navy"></i>Input Pengerjaan Mekanik</span>
                    <i class="bi bi-chevron-right small"></i>
                </a>
                <a href="{{ route('pembayaran-service.index') }}" class="btn btn-outline-secondary w-100 text-start d-flex align-items-center justify-content-between py-2 px-3">
                    <span><i class="bi bi-cash-coin me-2 text-success"></i>Proses Pembayaran Kasir</span>
                    <i class="bi bi-chevron-right small"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Servis Terbaru -->
<div class="card">
    <div class="card-header py-3 px-4 d-flex flex-wrap gap-2 align-items-center justify-content-between">
        <div>
            <h6 class="mb-0 fw-bold text-mc-navy"><i class="bi bi-clock-history me-2 text-mc-orange"></i>Servis Terbaru</h6>
            <small class="text-muted">Daftar antrean dan progres pengerjaan kendaraan terkini</small>
        </div>
        <a href="{{ route('daftar-service.index') }}" class="btn btn-sm btn-mc-navy px-3">
            Lihat Semua Servis <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">ID Servis</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Keluhan</th>
                        <th>Status Servis</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentServices as $srv)
                        @php
                            $hasPengerjaan = $srv->dataServices->isNotEmpty();
                            $hasPembayaran = $srv->pembayaranServices->isNotEmpty();
                        @endphp
                        <tr>
                            <td class="ps-4 fw-bold text-mc-navy">{{ $srv->id_servis }}</td>
                            <td class="text-secondary">{{ \Carbon\Carbon::parse($srv->tanggal_servis)->format('d M Y') }}</td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $srv->pelanggan->nama_lengkap ?? '-' }}</div>
                                <div class="small text-muted">{{ $srv->id_pelanggan }}</div>
                            </td>
                            <td>
                                <span class="badge bg-mc-navy">{{ $srv->no_plat }}</span>
                                <div class="small text-muted mt-1">{{ $srv->kendaraan->jenis_kendaraan ?? '-' }}</div>
                            </td>
                            <td style="max-width: 240px;">
                                <span class="text-truncate d-inline-block w-100" title="{{ $srv->keluhan_kendaraan }}">{{ $srv->keluhan_kendaraan }}</span>
                            </td>
                            <td>
                                @if($hasPembayaran)
                                    <span class="badge badge-soft-success"><i class="bi bi-check-circle-fill me-1"></i>Selesai & Lunas</span>
                                @elseif($hasPengerjaan)
                                    <span class="badge badge-soft-navy"><i class="bi bi-gear-fill me-1"></i>Sedang Dikerjakan</span>
                                @else
                                    <span class="badge badge-soft-warning"><i class="bi bi-clock-fill me-1"></i>Menunggu</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('detail-servis.show', $srv->id_servis) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                Belum ada data pendaftaran servis.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
