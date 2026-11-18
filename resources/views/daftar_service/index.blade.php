@extends('layouts.app')

@section('title', 'Daftar Servis - MotorCare')
@section('page_title', 'Pendaftaran Servis Kendaraan')
@section('page_subtitle', 'Kelola antrean pendaftaran servis pelanggan beserta keluhan kendaraan')

@section('content')
<div class="card">
    <div class="card-header py-3 px-4 d-flex flex-wrap gap-3 justify-content-between align-items-center">
        <div class="d-flex flex-wrap gap-2 align-items-center flex-grow-1">
            <div class="input-group" style="max-width: 320px;">
                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" id="searchDaftarServis" class="form-control border-start-0 ps-0" placeholder="Cari ID servis, plat, pelanggan, keluhan...">
            </div>
            <select id="filterStatusServis" class="form-select" style="max-width: 210px;">
                <option value="">Semua Status Servis</option>
                <option value="menunggu">Menunggu Mekanik</option>
                <option value="dikerjakan">Sedang Dikerjakan</option>
                <option value="selesai">Selesai & Lunas</option>
            </select>
        </div>
        <button class="btn btn-mc-orange px-3" data-bs-toggle="modal" data-bs-target="#modalTambahDaftarService">
            <i class="bi bi-plus-lg me-1"></i> Tambah Pendaftaran Servis
        </button>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">ID Servis</th>
                        <th>Tanggal Servis</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Keluhan Kendaraan</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($daftarServices as $ds)
                        @php
                            $safeId = preg_replace('/[^A-Za-z0-9]/', '_', $ds->id_servis);
                            $hasPengerjaan = $ds->dataServices->isNotEmpty();
                            $hasPembayaran = $ds->pembayaranServices->isNotEmpty();
                            $statusKey = $hasPembayaran ? 'selesai' : ($hasPengerjaan ? 'dikerjakan' : 'menunggu');
                        @endphp
                        <tr class="daftar-servis-row"
                            data-search="{{ strtolower($ds->id_servis . ' ' . $ds->no_plat . ' ' . $ds->id_pelanggan . ' ' . ($ds->pelanggan->nama_lengkap ?? '') . ' ' . $ds->keluhan_kendaraan) }}"
                            data-status="{{ $statusKey }}">
                            <td class="ps-4">
                                <a href="{{ route('detail-servis.show', $ds->id_servis) }}" class="fw-bold text-mc-navy text-decoration-none">
                                    {{ $ds->id_servis }}
                                </a>
                            </td>
                            <td class="text-secondary">{{ \Carbon\Carbon::parse($ds->tanggal_servis)->format('d M Y') }}</td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $ds->pelanggan->nama_lengkap ?? '-' }}</div>
                                <div class="small text-muted">{{ $ds->id_pelanggan }}</div>
                            </td>
                            <td>
                                <span class="badge bg-mc-navy">{{ $ds->no_plat }}</span>
                                <div class="small text-muted mt-1">{{ $ds->kendaraan->jenis_kendaraan ?? '-' }}</div>
                            </td>
                            <td style="max-width: 250px;">
                                <span class="text-secondary">{{ $ds->keluhan_kendaraan }}</span>
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
                                <div class="btn-group" role="group">
                                    <a href="{{ route('detail-servis.show', $ds->id_servis) }}" class="btn btn-sm btn-outline-secondary" title="Lihat Detail Servis">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-warning" title="Edit Pendaftaran" data-bs-toggle="modal" data-bs-target="#modalEditDaftarService{{ $safeId }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('daftar-service.destroy', $ds->id_servis) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pendaftaran servis {{ $ds->id_servis }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-start-0" title="Hapus Pendaftaran">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Edit Daftar Servis -->
                        <div class="modal fade" id="modalEditDaftarService{{ $safeId }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('daftar-service.update', $ds->id_servis) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold text-mc-navy">Edit Pendaftaran Servis</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold small">ID Servis Pelanggan</label>
                                                    <input type="text" class="form-control bg-light fw-bold text-mc-navy" value="{{ $ds->id_servis }}" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold small">Tanggal Servis</label>
                                                    <input type="date" name="tanggal_servis" class="form-control" value="{{ $ds->tanggal_servis }}" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small">ID Pelanggan</label>
                                                <select name="id_pelanggan" class="form-select select-pelanggan-autofill" data-target="#editNamaPelanggan{{ $safeId }}" required>
                                                    <option value="">-- Pilih ID Pelanggan --</option>
                                                    @foreach($pelanggans as $p)
                                                        <option value="{{ $p->id_pelanggan }}" data-nama="{{ $p->nama_lengkap }}" {{ $ds->id_pelanggan === $p->id_pelanggan ? 'selected' : '' }}>
                                                            {{ $p->id_pelanggan }} - {{ $p->nama_lengkap }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small">Nama Pelanggan (Otomatis)</label>
                                                <input type="text" id="editNamaPelanggan{{ $safeId }}" class="form-control bg-light fw-medium" value="{{ $ds->pelanggan->nama_lengkap ?? '' }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small">Nomor Plat Kendaraan</label>
                                                <select name="no_plat" class="form-select" required>
                                                    <option value="">-- Pilih Nomor Plat --</option>
                                                    @foreach($kendaraans as $k)
                                                        <option value="{{ $k->no_plat }}" {{ $ds->no_plat === $k->no_plat ? 'selected' : '' }}>
                                                            {{ $k->no_plat }} ({{ $k->jenis_kendaraan }} - {{ $k->nama_pemilik }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label fw-semibold small">Keluhan Kendaraan</label>
                                                <textarea name="keluhan_kendaraan" class="form-control" rows="3" required>{{ $ds->keluhan_kendaraan }}</textarea>
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
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-clipboard2-x fs-2 d-block mb-2"></i>
                                Belum ada data pendaftaran servis.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Daftar Servis -->
<div class="modal fade" id="modalTambahDaftarService" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('daftar-service.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title fw-bold text-mc-navy">Form Pendaftaran Servis Baru</h5>
                        <small class="text-muted">Catat kedatangan kendaraan dan keluhan pelanggan</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">ID Servis Pelanggan</label>
                            <input type="text" name="id_servis" class="form-control" placeholder="Contoh: SRV-001" required maxlength="20">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Tanggal Servis</label>
                            <input type="date" name="tanggal_servis" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">ID Pelanggan</label>
                        <select name="id_pelanggan" class="form-select select-pelanggan-autofill" data-target="#tambahNamaPelanggan" required>
                            <option value="">-- Pilih ID Pelanggan --</option>
                            @foreach($pelanggans as $p)
                                <option value="{{ $p->id_pelanggan }}" data-nama="{{ $p->nama_lengkap }}">
                                    {{ $p->id_pelanggan }} - {{ $p->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Nama Pelanggan (Otomatis)</label>
                        <input type="text" id="tambahNamaPelanggan" class="form-control bg-light fw-medium" placeholder="Otomatis terisi setelah ID pelanggan dipilih" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Nomor Plat Kendaraan</label>
                        <select name="no_plat" class="form-select" required>
                            <option value="">-- Pilih Nomor Plat Kendaraan --</option>
                            @foreach($kendaraans as $k)
                                <option value="{{ $k->no_plat }}">
                                    {{ $k->no_plat }} ({{ $k->jenis_kendaraan }} - {{ $k->nama_pemilik }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold small">Keluhan Kendaraan</label>
                        <textarea name="keluhan_kendaraan" class="form-control" rows="3" placeholder="Tuliskan detail keluhan motor pelanggan..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-mc-orange px-4">Simpan Pendaftaran</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.select-pelanggan-autofill').forEach(function (selectEl) {
            selectEl.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const namaLengkap = selectedOption.getAttribute('data-nama') || '';
                const targetInput = document.querySelector(this.getAttribute('data-target'));
                if (targetInput) {
                    targetInput.value = namaLengkap;
                }
            });
        });

        const searchInput = document.getElementById('searchDaftarServis');
        const filterStatus = document.getElementById('filterStatusServis');
        const rows = document.querySelectorAll('.daftar-servis-row');

        function filterTable() {
            const q = (searchInput?.value || '').toLowerCase().trim();
            const st = (filterStatus?.value || '').toLowerCase().trim();

            rows.forEach(row => {
                const matchSearch = !q || row.dataset.search.includes(q);
                const matchStatus = !st || row.dataset.status === st;
                row.style.display = (matchSearch && matchStatus) ? '' : 'none';
            });
        }

        searchInput?.addEventListener('input', filterTable);
        filterStatus?.addEventListener('change', filterTable);
    });
</script>
@endpush
