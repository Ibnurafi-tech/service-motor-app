@extends('layouts.app')

@section('title', 'Data Kendaraan - MotorCare')
@section('page_title', 'Manajemen Data Kendaraan')
@section('page_subtitle', 'Daftar unit motor pelanggan, nomor plat, transmisi, dan data STNK')

@section('content')
<div class="card">
    <div class="card-header py-3 px-4 d-flex flex-wrap gap-3 justify-content-between align-items-center">
        <div class="d-flex flex-wrap gap-2 align-items-center flex-grow-1">
            <div class="input-group" style="max-width: 320px;">
                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" id="searchKendaraan" class="form-control border-start-0 ps-0" placeholder="Cari plat, STNK, pemilik, warna...">
            </div>
            <select id="filterJenis" class="form-select" style="max-width: 210px;">
                <option value="">Semua Jenis Transmisi</option>
                <option value="matic">Matic</option>
                <option value="manual transmisi">Manual Transmisi</option>
            </select>
        </div>
        <button class="btn btn-mc-orange px-3" data-bs-toggle="modal" data-bs-target="#modalTambahKendaraan">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kendaraan
        </button>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Nomor Plat</th>
                        <th>Jenis Kendaraan</th>
                        <th>Nomor STNK</th>
                        <th>Tahun</th>
                        <th>Nama Pemilik</th>
                        <th>Warna</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kendaraans as $k)
                        @php $safeId = preg_replace('/[^A-Za-z0-9]/', '_', $k->no_plat); @endphp
                        <tr class="kendaraan-row"
                            data-search="{{ strtolower($k->no_plat . ' ' . $k->jenis_kendaraan . ' ' . $k->no_stnk . ' ' . $k->tahun_pembuatan . ' ' . $k->nama_pemilik . ' ' . $k->warna_kendaraan) }}"
                            data-jenis="{{ strtolower($k->jenis_kendaraan) }}">
                            <td class="ps-4">
                                <span class="badge bg-mc-navy px-2.5 py-1.5 fs-6" style="letter-spacing: 0.04em;">{{ $k->no_plat }}</span>
                            </td>
                            <td>
                                @if($k->jenis_kendaraan === 'Matic')
                                    <span class="badge badge-soft-orange"><i class="bi bi-gear me-1"></i>Matic</span>
                                @else
                                    <span class="badge badge-soft-navy"><i class="bi bi-sliders me-1"></i>Manual Transmisi</span>
                                @endif
                            </td>
                            <td class="text-secondary fw-medium">{{ $k->no_stnk }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $k->tahun_pembuatan }}</span></td>
                            <td class="fw-semibold text-dark">{{ $k->nama_pemilik }}</td>
                            <td>
                                <span class="d-inline-flex align-items-center gap-1.5 text-secondary">
                                    <i class="bi bi-palette text-muted"></i> {{ $k->warna_kendaraan }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" title="Detail Kendaraan" data-bs-toggle="modal" data-bs-target="#modalDetailKendaraan{{ $safeId }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-warning" title="Edit Kendaraan" data-bs-toggle="modal" data-bs-target="#modalEditKendaraan{{ $safeId }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('kendaraan.destroy', $k->no_plat) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kendaraan {{ $k->no_plat }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-start-0" title="Hapus Kendaraan">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Detail Kendaraan -->
                        <div class="modal fade" id="modalDetailKendaraan{{ $safeId }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div>
                                            <h5 class="modal-title fw-bold text-mc-navy">Detail Kendaraan</h5>
                                            <small class="text-muted">Spesifikasi unit motor terdaftar</small>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="p-3 rounded-3 bg-light border d-flex align-items-center justify-content-between mb-3">
                                            <div>
                                                <div class="small text-muted">Nomor Polisi / Plat</div>
                                                <div class="fs-5 fw-bold text-mc-navy">{{ $k->no_plat }}</div>
                                            </div>
                                            <span class="badge {{ $k->jenis_kendaraan === 'Matic' ? 'badge-soft-orange' : 'badge-soft-navy' }} px-3 py-2">
                                                {{ $k->jenis_kendaraan }}
                                            </span>
                                        </div>
                                        <div class="row g-3 small">
                                            <div class="col-6">
                                                <div class="text-muted">Nama Pemilik</div>
                                                <div class="fw-semibold text-dark mt-0.5">{{ $k->nama_pemilik }}</div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-muted">Nomor STNK</div>
                                                <div class="fw-semibold text-dark mt-0.5">{{ $k->no_stnk }}</div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-muted">Tahun Pembuatan</div>
                                                <div class="fw-semibold text-dark mt-0.5">{{ $k->tahun_pembuatan }}</div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-muted">Warna Kendaraan</div>
                                                <div class="fw-semibold text-dark mt-0.5">{{ $k->warna_kendaraan }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Edit Kendaraan -->
                        <div class="modal fade" id="modalEditKendaraan{{ $safeId }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('kendaraan.update', $k->no_plat) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold text-mc-navy">Edit Data Kendaraan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small">Nomor Plat Kendaraan</label>
                                                <input type="text" class="form-control bg-light fw-bold text-mc-navy" value="{{ $k->no_plat }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small d-block">Jenis Kendaraan</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check border rounded-3 px-3 py-2 flex-fill">
                                                        <input class="form-check-input ms-0 me-2" type="radio" name="jenis_kendaraan" id="editMatic{{ $safeId }}" value="Matic" {{ $k->jenis_kendaraan === 'Matic' ? 'checked' : '' }} required>
                                                        <label class="form-check-label fw-medium" for="editMatic{{ $safeId }}">Matic</label>
                                                    </div>
                                                    <div class="form-check border rounded-3 px-3 py-2 flex-fill">
                                                        <input class="form-check-input ms-0 me-2" type="radio" name="jenis_kendaraan" id="editManual{{ $safeId }}" value="Manual Transmisi" {{ $k->jenis_kendaraan === 'Manual Transmisi' ? 'checked' : '' }} required>
                                                        <label class="form-check-label fw-medium" for="editManual{{ $safeId }}">Manual Transmisi</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small">Nomor STNK</label>
                                                <input type="text" name="no_stnk" class="form-control" value="{{ $k->no_stnk }}" required maxlength="30">
                                            </div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold small">Tahun Pembuatan</label>
                                                    <input type="number" name="tahun_pembuatan" class="form-control" value="{{ $k->tahun_pembuatan }}" min="1980" max="2030" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold small">Warna Kendaraan</label>
                                                    <input type="text" name="warna_kendaraan" class="form-control" value="{{ $k->warna_kendaraan }}" required maxlength="30">
                                                </div>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label fw-semibold small">Nama Pemilik</label>
                                                <input type="text" name="nama_pemilik" class="form-control" value="{{ $k->nama_pemilik }}" required maxlength="100">
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
                                <i class="bi bi-bicycle fs-2 d-block mb-2"></i>
                                Belum ada data kendaraan terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Kendaraan -->
<div class="modal fade" id="modalTambahKendaraan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('kendaraan.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title fw-bold text-mc-navy">Tambah Kendaraan Baru</h5>
                        <small class="text-muted">Daftarkan unit motor pelanggan ke sistem</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Nomor Plat Kendaraan</label>
                        <input type="text" name="no_plat" class="form-control text-uppercase" placeholder="Contoh: BL 1234 AB" required maxlength="20">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small d-block">Jenis Kendaraan</label>
                        <div class="d-flex gap-3">
                            <div class="form-check border rounded-3 px-3 py-2 flex-fill">
                                <input class="form-check-input ms-0 me-2" type="radio" name="jenis_kendaraan" id="tambahMatic" value="Matic" checked required>
                                <label class="form-check-label fw-medium" for="tambahMatic">Matic</label>
                            </div>
                            <div class="form-check border rounded-3 px-3 py-2 flex-fill">
                                <input class="form-check-input ms-0 me-2" type="radio" name="jenis_kendaraan" id="tambahManual" value="Manual Transmisi" required>
                                <label class="form-check-label fw-medium" for="tambahManual">Manual Transmisi</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Nomor STNK</label>
                        <input type="text" name="no_stnk" class="form-control" placeholder="Masukkan nomor STNK" required maxlength="30">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Tahun Pembuatan</label>
                            <input type="number" name="tahun_pembuatan" class="form-control" placeholder="2024" min="1980" max="2030" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Warna Kendaraan</label>
                            <input type="text" name="warna_kendaraan" class="form-control" placeholder="Hitam / Merah" required maxlength="30">
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold small">Nama Pemilik</label>
                        <input type="text" name="nama_pemilik" class="form-control" placeholder="Nama pemilik sesuai STNK" required maxlength="100">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-mc-orange px-4">Simpan Kendaraan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchKendaraan');
        const filterJenis = document.getElementById('filterJenis');
        const rows = document.querySelectorAll('.kendaraan-row');

        function filterTable() {
            const q = (searchInput?.value || '').toLowerCase().trim();
            const jenis = (filterJenis?.value || '').toLowerCase().trim();

            rows.forEach(row => {
                const matchSearch = !q || row.dataset.search.includes(q);
                const matchJenis = !jenis || row.dataset.jenis === jenis;
                row.style.display = (matchSearch && matchJenis) ? '' : 'none';
            });
        }

        searchInput?.addEventListener('input', filterTable);
        filterJenis?.addEventListener('change', filterTable);
    });
</script>
@endpush
