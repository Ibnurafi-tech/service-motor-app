@extends('layouts.app')

@section('title', 'Data Pelanggan - MotorCare')
@section('page_title', 'Manajemen Data Pelanggan')
@section('page_subtitle', 'Kelola informasi pelanggan bengkel, kontak, alamat, dan riwayat servis')

@section('content')
<div class="card">
    <div class="card-header py-3 px-4 d-flex flex-wrap gap-3 justify-content-between align-items-center">
        <div class="d-flex flex-wrap gap-2 align-items-center flex-grow-1">
            <div class="input-group" style="max-width: 320px;">
                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" id="searchPelanggan" class="form-control border-start-0 ps-0" placeholder="Cari ID, nama, HP, atau alamat...">
            </div>
            <select id="filterPekerjaan" class="form-select" style="max-width: 210px;">
                <option value="">Semua Pekerjaan</option>
                @foreach($pelanggans->pluck('pekerjaan')->unique()->filter() as $job)
                    <option value="{{ strtolower($job) }}">{{ $job }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-mc-orange px-3" data-bs-toggle="modal" data-bs-target="#modalTambahPelanggan">
            <i class="bi bi-plus-lg me-1"></i> Tambah Pelanggan
        </button>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tablePelanggan">
                <thead>
                    <tr>
                        <th class="ps-4">ID Pelanggan</th>
                        <th>Nama Lengkap</th>
                        <th>Nomor HP</th>
                        <th>Pekerjaan</th>
                        <th>Alamat Pelanggan</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggans as $p)
                        @php $safeId = preg_replace('/[^A-Za-z0-9]/', '_', $p->id_pelanggan); @endphp
                        <tr class="pelanggan-row"
                            data-search="{{ strtolower($p->id_pelanggan . ' ' . $p->nama_lengkap . ' ' . $p->no_hp . ' ' . $p->alamat . ' ' . $p->pekerjaan) }}"
                            data-pekerjaan="{{ strtolower($p->pekerjaan) }}">
                            <td class="ps-4">
                                <span class="badge badge-soft-navy px-2.5 py-1.5">{{ $p->id_pelanggan }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $p->nama_lengkap }}</div>
                            </td>
                            <td>
                                <span class="text-secondary"><i class="bi bi-telephone me-1 text-muted"></i>{{ $p->no_hp }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border fw-medium">{{ $p->pekerjaan }}</span>
                            </td>
                            <td style="max-width: 260px;">
                                <span class="text-secondary">{{ $p->alamat }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" title="Detail Pelanggan" data-bs-toggle="modal" data-bs-target="#modalDetailPelanggan{{ $safeId }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-warning" title="Edit Pelanggan" data-bs-toggle="modal" data-bs-target="#modalEditPelanggan{{ $safeId }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('pelanggan.destroy', $p->id_pelanggan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data pelanggan {{ $p->nama_lengkap }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-start-0" title="Hapus Pelanggan">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Detail Pelanggan -->
                        <div class="modal fade" id="modalDetailPelanggan{{ $safeId }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div>
                                            <h5 class="modal-title fw-bold text-mc-navy">Detail Pelanggan</h5>
                                            <small class="text-muted">Informasi profil & kontak pelanggan</small>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light border mb-3">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white fs-5" style="width: 48px; height: 48px; background-color: var(--mc-navy);">
                                                {{ strtoupper(substr($p->nama_lengkap, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold fs-6 text-mc-navy">{{ $p->nama_lengkap }}</div>
                                                <span class="badge badge-soft-orange">{{ $p->id_pelanggan }}</span>
                                            </div>
                                        </div>
                                        <div class="row g-3 small">
                                            <div class="col-6">
                                                <div class="text-muted">Nomor HP</div>
                                                <div class="fw-semibold text-dark mt-0.5">{{ $p->no_hp }}</div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-muted">Pekerjaan</div>
                                                <div class="fw-semibold text-dark mt-0.5">{{ $p->pekerjaan }}</div>
                                            </div>
                                            <div class="col-12">
                                                <div class="text-muted">Alamat Lengkap</div>
                                                <div class="fw-semibold text-dark mt-0.5">{{ $p->alamat }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Edit Pelanggan -->
                        <div class="modal fade" id="modalEditPelanggan{{ $safeId }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('pelanggan.update', $p->id_pelanggan) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold text-mc-navy">Edit Data Pelanggan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small">ID Pelanggan</label>
                                                <input type="text" class="form-control bg-light fw-bold text-mc-navy" value="{{ $p->id_pelanggan }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small">Nama Lengkap</label>
                                                <input type="text" name="nama_lengkap" class="form-control" value="{{ $p->nama_lengkap }}" required maxlength="100">
                                            </div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold small">Nomor HP</label>
                                                    <input type="text" name="no_hp" class="form-control" value="{{ $p->no_hp }}" required maxlength="15">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold small">Pekerjaan</label>
                                                    <input type="text" name="pekerjaan" class="form-control" value="{{ $p->pekerjaan }}" required maxlength="50">
                                                </div>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label fw-semibold small">Alamat Pelanggan</label>
                                                <textarea name="alamat" class="form-control" rows="3" required>{{ $p->alamat }}</textarea>
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
                                <i class="bi bi-people fs-2 d-block mb-2"></i>
                                Belum ada data pelanggan terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Pelanggan -->
<div class="modal fade" id="modalTambahPelanggan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('pelanggan.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title fw-bold text-mc-navy">Tambah Pelanggan Baru</h5>
                        <small class="text-muted">Lengkapi identitas pelanggan bengkel</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">ID Pelanggan</label>
                        <input type="text" name="id_pelanggan" class="form-control" placeholder="Contoh: PLG-001" required maxlength="20">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap pelanggan" required maxlength="100">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Nomor HP</label>
                            <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" required maxlength="15">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control" placeholder="Mahasiswa / Wiraswasta" required maxlength="50">
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold small">Alamat Pelanggan</label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap domisili" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-mc-orange px-4">Simpan Pelanggan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchPelanggan');
        const filterJob = document.getElementById('filterPekerjaan');
        const rows = document.querySelectorAll('.pelanggan-row');

        function filterTable() {
            const q = (searchInput?.value || '').toLowerCase().trim();
            const job = (filterJob?.value || '').toLowerCase().trim();

            rows.forEach(row => {
                const matchSearch = !q || row.dataset.search.includes(q);
                const matchJob = !job || row.dataset.pekerjaan === job;
                row.style.display = (matchSearch && matchJob) ? '' : 'none';
            });
        }

        searchInput?.addEventListener('input', filterTable);
        filterJob?.addEventListener('change', filterTable);
    });
</script>
@endpush
