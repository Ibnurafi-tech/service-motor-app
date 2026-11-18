@extends('layouts.app')

@section('title', 'Data Servis - MotorCare')
@section('page_title', 'Data Pengerjaan Servis & Mekanik')
@section('page_subtitle', 'Kelola penugasan mekanik, estimasi waktu pengerjaan, dan penggantian sparepart')

@section('content')
<div class="card">
    <div class="card-header py-3 px-4 d-flex flex-wrap gap-3 justify-content-between align-items-center">
        <div class="d-flex flex-wrap gap-2 align-items-center flex-grow-1">
            <div class="input-group" style="max-width: 320px;">
                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" id="searchDataServis" class="form-control border-start-0 ps-0" placeholder="Cari ID servis, mekanik, sparepart...">
            </div>
            <select id="filterMekanik" class="form-select" style="max-width: 210px;">
                <option value="">Semua Mekanik</option>
                @foreach($dataServices->pluck('nama_mekanik')->unique()->filter() as $mekanik)
                    <option value="{{ strtolower($mekanik) }}">{{ $mekanik }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-mc-orange px-3" data-bs-toggle="modal" data-bs-target="#modalTambahDataService">
            <i class="bi bi-plus-lg me-1"></i> Tambah Data Servis
        </button>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">ID Servis & Pelanggan</th>
                        <th>Keluhan Kendaraan</th>
                        <th>Estimasi Servis</th>
                        <th>Nama Mekanik</th>
                        <th>Sparepart Pengganti</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataServices as $dts)
                        <tr class="data-servis-row"
                            data-search="{{ strtolower($dts->id_servis . ' ' . ($dts->daftarService->pelanggan->nama_lengkap ?? '') . ' ' . ($dts->daftarService->keluhan_kendaraan ?? '') . ' ' . $dts->nama_mekanik . ' ' . ($dts->sparepart_pengganti ?? '')) }}"
                            data-mekanik="{{ strtolower($dts->nama_mekanik) }}">
                            <td class="ps-4">
                                <a href="{{ route('detail-servis.show', $dts->id_servis) }}" class="fw-bold text-mc-navy text-decoration-none">
                                    {{ $dts->id_servis }}
                                </a>
                                <div class="small text-muted">{{ $dts->daftarService->pelanggan->nama_lengkap ?? '-' }} ({{ $dts->daftarService->no_plat ?? '-' }})</div>
                            </td>
                            <td style="max-width: 230px;">
                                <span class="text-secondary">{{ $dts->daftarService->keluhan_kendaraan ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="badge badge-soft-orange"><i class="bi bi-stopwatch me-1"></i>{{ $dts->estimasi_service }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="rounded-circle d-inline-flex align-items-center justify-content-center fw-bold text-white" style="width: 28px; height: 28px; background-color: var(--mc-navy); font-size: 0.72rem;">
                                        {{ strtoupper(substr($dts->nama_mekanik, 0, 1)) }}
                                    </span>
                                    <span class="fw-semibold text-dark">{{ $dts->nama_mekanik }}</span>
                                </div>
                            </td>
                            <td style="max-width: 220px;">
                                @if($dts->sparepart_pengganti)
                                    <span class="text-dark">{{ $dts->sparepart_pengganti }}</span>
                                @else
                                    <span class="text-muted fst-italic small">Tanpa ganti sparepart</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('detail-servis.show', $dts->id_servis) }}" class="btn btn-sm btn-outline-secondary" title="Lihat Detail Servis">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-warning" title="Edit Data Servis" data-bs-toggle="modal" data-bs-target="#modalEditDataService{{ $dts->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('data-service.destroy', $dts->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data pengerjaan servis ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-start-0" title="Hapus Data Servis">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Edit Data Servis -->
                        <div class="modal fade" id="modalEditDataService{{ $dts->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('data-service.update', $dts->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold text-mc-navy">Edit Pengerjaan Servis</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small">ID Servis Pelanggan</label>
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
                                                <label class="form-label fw-semibold small">Keluhan Kendaraan (Otomatis)</label>
                                                <textarea id="editKeluhanServis{{ $dts->id }}" class="form-control bg-light" rows="2" readonly>{{ $dts->daftarService->keluhan_kendaraan ?? '' }}</textarea>
                                            </div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold small">Estimasi Servis</label>
                                                    <input type="text" name="estimasi_service" class="form-control" value="{{ $dts->estimasi_service }}" required maxlength="50">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold small">Nama Mekanik</label>
                                                    <input type="text" name="nama_mekanik" class="form-control" value="{{ $dts->nama_mekanik }}" required maxlength="100">
                                                </div>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label fw-semibold small">Sparepart Pengganti (Opsional)</label>
                                                <textarea name="sparepart_pengganti" class="form-control" rows="3">{{ $dts->sparepart_pengganti }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-mc-orange px-4">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-wrench-adjustable-circle fs-2 d-block mb-2"></i>
                                Belum ada data pengerjaan servis.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Data Servis -->
<div class="modal fade" id="modalTambahDataService" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('data-service.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title fw-bold text-mc-navy">Form Pengerjaan Servis Mekanik</h5>
                        <small class="text-muted">Tetapkan mekanik dan estimasi pengerjaan kendaraan</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">ID Servis Pelanggan</label>
                        <select name="id_servis" class="form-select select-servis-autofill" data-target="#tambahKeluhanServis" required>
                            <option value="">-- Pilih ID Servis dari Pendaftaran --</option>
                            @foreach($daftarServices as $srv)
                                <option value="{{ $srv->id_servis }}" data-keluhan="{{ $srv->keluhan_kendaraan }}">
                                    {{ $srv->id_servis }} - {{ $srv->pelanggan->nama_lengkap ?? '-' }} ({{ $srv->no_plat }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Keluhan Kendaraan (Otomatis)</label>
                        <textarea id="tambahKeluhanServis" class="form-control bg-light" rows="2" placeholder="Keluhan muncul otomatis setelah ID servis dipilih" readonly></textarea>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Estimasi Servis</label>
                            <input type="text" name="estimasi_service" class="form-control" placeholder="Contoh: 45 Menit / 2 Jam" required maxlength="50">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Nama Mekanik</label>
                            <input type="text" name="nama_mekanik" class="form-control" placeholder="Nama mekanik penanggung jawab" required maxlength="100">
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold small">Sparepart Pengganti (Opsional)</label>
                        <textarea name="sparepart_pengganti" class="form-control" rows="3" placeholder="Contoh: Oli Mesin MPX2, Kampas Rem Depan, Busi..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-mc-orange px-4">Simpan Pengerjaan</button>
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

        const searchInput = document.getElementById('searchDataServis');
        const filterMekanik = document.getElementById('filterMekanik');
        const rows = document.querySelectorAll('.data-servis-row');

        function filterTable() {
            const q = (searchInput?.value || '').toLowerCase().trim();
            const mek = (filterMekanik?.value || '').toLowerCase().trim();

            rows.forEach(row => {
                const matchSearch = !q || row.dataset.search.includes(q);
                const matchMek = !mek || row.dataset.mekanik === mek;
                row.style.display = (matchSearch && matchMek) ? '' : 'none';
            });
        }

        searchInput?.addEventListener('input', filterTable);
        filterMekanik?.addEventListener('change', filterTable);
    });
</script>
@endpush
