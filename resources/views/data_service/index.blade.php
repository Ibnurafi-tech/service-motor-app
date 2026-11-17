@extends('layouts.app')

@section('title', 'Data Service - Service Motor App')
@section('page_title', 'Data Pengerjaan & Mekanik Service')

@section('content')
<div class="card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold"><i class="bi bi-wrench-adjustable-circle me-2 text-primary"></i>Daftar Pengerjaan Service</h6>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahDataService">
            <i class="bi bi-plus-circle me-1"></i> Tambah Data Service
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>ID Servis & Pelanggan</th>
                        <th>Keluhan Kendaraan</th>
                        <th>Estimasi Service</th>
                        <th>Nama Mekanik</th>
                        <th>Sparepart Pengganti</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataServices as $index => $dts)
                        <tr>
                            <td class="ps-4">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-semibold text-primary">{{ $dts->id_servis }}</div>
                                <small class="text-muted">{{ $dts->daftarService->pelanggan->nama_lengkap ?? '-' }}</small>
                            </td>
                            <td>{{ $dts->daftarService->keluhan_kendaraan ?? '-' }}</td>
                            <td><span class="badge bg-info text-dark">{{ $dts->estimasi_service }}</span></td>
                            <td class="fw-semibold">{{ $dts->nama_mekanik }}</td>
                            <td>{{ $dts->sparepart_pengganti ?: '-' }}</td>
                            <td class="text-center pe-4">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditDataService{{ $dts->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('data-service.destroy', $dts->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data pengerjaan servis ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEditDataService{{ $dts->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('data-service.update', $dts->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Edit Data Service</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Pilih ID Servis</label>
                                                <select name="id_servis" class="form-select select-servis-autofill" data-target="#editKeluhanServis{{ $dts->id }}" required>
                                                    <option value="">-- Pilih ID Servis --</option>
                                                    @foreach($daftarServices as $srv)
                                                        <option value="{{ $srv->id_servis }}" data-keluhan="{{ $srv->keluhan_kendaraan }}" {{ $dts->id_servis === $srv->id_servis ? 'selected' : '' }}>
                                                            {{ $srv->id_servis }} - {{ $srv->pelanggan->nama_lengkap ?? '-' }} ({{ $srv->no_plat }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Keluhan Kendaraan (Auto-Fill)</label>
                                                <textarea id="editKeluhanServis{{ $dts->id }}" class="form-control bg-light" rows="2" readonly>{{ $dts->daftarService->keluhan_kendaraan ?? '' }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Estimasi Waktu Service</label>
                                                <input type="text" name="estimasi_service" class="form-control" value="{{ $dts->estimasi_service }}" required maxlength="50">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Nama Mekanik</label>
                                                <input type="text" name="nama_mekanik" class="form-control" value="{{ $dts->nama_mekanik }}" required maxlength="100">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Sparepart Pengganti (Opsional)</label>
                                                <textarea name="sparepart_pengganti" class="form-control" rows="3">{{ $dts->sparepart_pengganti }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data pengerjaan service.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahDataService" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('data-service.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Data Pengerjaan Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih ID Servis</label>
                        <select name="id_servis" class="form-select select-servis-autofill" data-target="#tambahKeluhanServis" required>
                            <option value="">-- Pilih ID Servis --</option>
                            @foreach($daftarServices as $srv)
                                <option value="{{ $srv->id_servis }}" data-keluhan="{{ $srv->keluhan_kendaraan }}">
                                    {{ $srv->id_servis }} - {{ $srv->pelanggan->nama_lengkap ?? '-' }} ({{ $srv->no_plat }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keluhan Kendaraan (Otomatis)</label>
                        <textarea id="tambahKeluhanServis" class="form-control bg-light" rows="2" placeholder="Otomatis terisi saat ID Servis dipilih" readonly></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Estimasi Waktu Service</label>
                        <input type="text" name="estimasi_service" class="form-control" placeholder="Contoh: 45 Menit / 2 Jam" required maxlength="50">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Mekanik</label>
                        <input type="text" name="nama_mekanik" class="form-control" placeholder="Masukkan nama mekanik" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Sparepart Pengganti (Opsional)</label>
                        <textarea name="sparepart_pengganti" class="form-control" rows="3" placeholder="Contoh: Oli Mesin MPX2, Kampas Rem Depan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.select-servis-autofill').forEach(function (selectEl) {
            selectEl.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const keluhan = selectedOption.getAttribute('data-keluhan') || '';
                const targetTextarea = document.querySelector(this.getAttribute('data-target'));
                if (targetTextarea) {
                    targetTextarea.value = keluhan;
                }
            });
        });
    });
</script>
@endpush
