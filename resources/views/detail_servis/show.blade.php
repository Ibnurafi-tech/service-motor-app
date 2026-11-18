@extends('layouts.app')

@section('title', 'Detail Servis ' . $servis->id_servis . ' - MotorCare')
@section('page_title', 'Detail Servis & Bukti Pembayaran')
@section('page_subtitle', 'Rincian informasi pelanggan, kendaraan, pengerjaan mekanik, dan status pembayaran')

@section('content')
@php
    $hasPengerjaan = $servis->dataServices->isNotEmpty();
    $hasPembayaran = $servis->pembayaranServices->isNotEmpty();
    $totalTagihan = $servis->pembayaranServices->sum('jumlah_biaya');
@endphp

<div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4 no-print">
    <a href="{{ route('daftar-service.index') }}" class="btn btn-light border px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Servis
    </a>
    <div class="d-flex gap-2">
        <button type="button" onclick="window.print()" class="btn btn-mc-navy px-3">
            <i class="bi bi-printer-fill me-1"></i> Cetak Bukti / Invoice Servis
        </button>
    </div>
</div>

<!-- Header Status & Ringkasan ID Servis -->
<div class="card mb-4">
    <div class="card-body p-4 d-flex flex-wrap gap-3 justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <div class="rounded-3 d-flex align-items-center justify-content-center text-white" style="width: 54px; height: 54px; background-color: var(--mc-navy);">
                <i class="bi bi-receipt-cutoff fs-3"></i>
            </div>
            <div>
                <div class="small text-muted fw-semibold text-uppercase">Kode Pendaftaran Servis</div>
                <div class="fs-4 fw-bold text-mc-navy">{{ $servis->id_servis }}</div>
                <div class="small text-secondary">
                    <i class="bi bi-calendar-event me-1 text-mc-orange"></i>
                    Tanggal Masuk: <strong>{{ \Carbon\Carbon::parse($servis->tanggal_servis)->translatedFormat('d F Y') }}</strong>
                </div>
            </div>
        </div>

        <div class="text-md-end">
            <div class="small text-muted mb-1">Status Pengerjaan Servis</div>
            @if($hasPembayaran)
                <span class="badge badge-soft-success fs-6 px-3 py-2"><i class="bi bi-check-circle-fill me-1"></i>Selesai & Sudah Dibayar</span>
            @elseif($hasPengerjaan)
                <span class="badge badge-soft-navy fs-6 px-3 py-2"><i class="bi bi-gear-fill me-1"></i>Sedang Dikerjakan Mekanik</span>
            @else
                <span class="badge badge-soft-warning fs-6 px-3 py-2"><i class="bi bi-hourglass-split me-1"></i>Menunggu Penanganan Mekanik</span>
            @endif
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Informasi Pelanggan -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header py-3 px-4">
                <h6 class="mb-0 fw-bold text-mc-navy"><i class="bi bi-person-vcard-fill me-2 text-mc-orange"></i>Informasi Pelanggan</h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3 small">
                    <div class="col-sm-6">
                        <div class="text-muted">ID Pelanggan</div>
                        <div class="fw-bold text-mc-navy fs-6 mt-0.5">{{ $servis->id_pelanggan }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted">Nama Lengkap</div>
                        <div class="fw-bold text-dark fs-6 mt-0.5">{{ $servis->pelanggan->nama_lengkap ?? '-' }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted">Nomor HP</div>
                        <div class="fw-semibold text-dark mt-0.5">{{ $servis->pelanggan->no_hp ?? '-' }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted">Pekerjaan</div>
                        <div class="fw-semibold text-dark mt-0.5">{{ $servis->pelanggan->pekerjaan ?? '-' }}</div>
                    </div>
                    <div class="col-12">
                        <div class="text-muted">Alamat Pelanggan</div>
                        <div class="fw-semibold text-dark mt-0.5">{{ $servis->pelanggan->alamat ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Kendaraan -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header py-3 px-4">
                <h6 class="mb-0 fw-bold text-mc-navy"><i class="bi bi-bicycle me-2 text-mc-orange"></i>Informasi Kendaraan</h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3 small">
                    <div class="col-sm-6">
                        <div class="text-muted">Nomor Plat Kendaraan</div>
                        <div class="mt-1"><span class="badge bg-mc-navy fs-6 px-3 py-1.5">{{ $servis->no_plat }}</span></div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted">Jenis Kendaraan</div>
                        <div class="fw-bold text-dark fs-6 mt-1">{{ $servis->kendaraan->jenis_kendaraan ?? '-' }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted">Nomor STNK</div>
                        <div class="fw-semibold text-dark mt-0.5">{{ $servis->kendaraan->no_stnk ?? '-' }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted">Tahun & Warna</div>
                        <div class="fw-semibold text-dark mt-0.5">{{ $servis->kendaraan->tahun_pembuatan ?? '-' }} &bull; {{ $servis->kendaraan->warna_kendaraan ?? '-' }}</div>
                    </div>
                    <div class="col-12">
                        <div class="text-muted">Nama Pemilik (STNK)</div>
                        <div class="fw-semibold text-dark mt-0.5">{{ $servis->kendaraan->nama_pemilik ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Keluhan & Pengerjaan Mekanik -->
<div class="card mb-4">
    <div class="card-header py-3 px-4">
        <h6 class="mb-0 fw-bold text-mc-navy"><i class="bi bi-wrench-adjustable-circle-fill me-2 text-mc-orange"></i>Keluhan & Rincian Pengerjaan Mekanik</h6>
    </div>
    <div class="card-body p-4">
        <div class="p-3 rounded-3 bg-light border mb-4">
            <div class="small fw-bold text-mc-navy text-uppercase mb-1">Keluhan Awal Pelanggan</div>
            <div class="text-dark">{{ $servis->keluhan_kendaraan }}</div>
        </div>

        @if($servis->dataServices->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nama Mekanik</th>
                            <th>Estimasi Waktu Servis</th>
                            <th>Sparepart Pengganti</th>
                            <th>Waktu Dicatat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($servis->dataServices as $dts)
                            <tr>
                                <td class="fw-bold text-mc-navy">{{ $dts->nama_mekanik }}</td>
                                <td><span class="badge badge-soft-orange">{{ $dts->estimasi_service }}</span></td>
                                <td>{{ $dts->sparepart_pengganti ?: 'Tidak ada penggantian sparepart' }}</td>
                                <td class="text-secondary small">{{ $dts->created_at ? $dts->created_at->format('d M Y, H:i') : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4 text-muted border rounded-3">
                <i class="bi bi-tools fs-3 d-block mb-1"></i>
                Belum ada data pengerjaan mekanik untuk servis ini.
                <div class="mt-2 no-print">
                    <a href="{{ route('data-service.index') }}" class="btn btn-sm btn-mc-orange">Input Data Pengerjaan</a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Informasi Pembayaran Servis -->
<div class="card">
    <div class="card-header py-3 px-4 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold text-mc-navy"><i class="bi bi-credit-card-2-front-fill me-2 text-mc-orange"></i>Informasi Pembayaran & Invoice</h6>
        @if($hasPembayaran)
            <span class="badge badge-soft-success">LUNAS</span>
        @else
            <span class="badge badge-soft-danger">BELUM DIBAYAR</span>
        @endif
    </div>
    <div class="card-body p-4">
        @if($servis->pembayaranServices->isNotEmpty())
            <div class="table-responsive mb-3">
                <table class="table table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Tanggal Pembayaran</th>
                            <th>Metode Pembayaran</th>
                            <th>Keterangan</th>
                            <th class="text-end">Jumlah Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($servis->pembayaranServices as $pb)
                            <tr>
                                <td>{{ $pb->created_at ? $pb->created_at->format('d M Y, H:i') : '-' }}</td>
                                <td>
                                    <span class="badge {{ $pb->jenis_pembayaran === 'Cash / Tunai' ? 'badge-soft-success' : 'badge-soft-navy' }}">
                                        {{ $pb->jenis_pembayaran }}
                                    </span>
                                </td>
                                <td>{{ $pb->keterangan ?: 'Pembayaran servis lunas' }}</td>
                                <td class="text-end fw-bold text-mc-navy">Rp {{ number_format($pb->jumlah_biaya, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-light">
                            <th colspan="3" class="text-end text-uppercase small text-secondary">Total Pembayaran Diterima</th>
                            <th class="text-end fs-5 fw-bold text-success">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="small text-muted text-end">
                Dicetak dari <strong>{{ session('mc_user.workshop_name', 'Bengkel MotorCare') }}</strong> &bull; {{ now()->translatedFormat('d F Y, H:i') }}
            </div>
        @else
            <div class="text-center py-4 text-muted border rounded-3">
                <i class="bi bi-wallet2 fs-3 d-block mb-1"></i>
                Transaksi pembayaran untuk servis ini belum diproses.
                <div class="mt-2 no-print">
                    <a href="{{ route('pembayaran-service.index') }}" class="btn btn-sm btn-mc-orange">Proses Pembayaran Sekarang</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const params = new URLSearchParams(window.location.search);
        if (params.get('print') === '1') {
            setTimeout(() => window.print(), 350);
        }
    });
</script>
@endpush
