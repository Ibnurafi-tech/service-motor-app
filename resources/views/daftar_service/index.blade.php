@extends('layouts.app')

@section('title', 'Daftar Service - Service Motor App')
@section('page_title', 'Pendaftaran Service Kendaraan')

@section('content')
<div class="card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold"><i class="bi bi-clipboard2-plus me-2 text-primary"></i>Data Pendaftaran Service</h6>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahDaftarService">
            <i class="bi bi-plus-circle me-1"></i> Tambah Pendaftaran
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID Servis</th>
                        <th>Tanggal Servis</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Keluhan Kendaraan</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($daftarServices as $ds)
                        @php $safeId = preg_replace('/[^A-Za-z0-9]/', '_', $ds->id_servis); @endphp
                        <tr>
                            <td class="ps-4 fw-semibold text-primary">{{ $ds->id_servis }}</td>
                            <td>{{ \Carbon\Carbon::parse($ds->tanggal_servis)->format('d/m/Y') }}</td>
                            <td>
                                <div class="fw-semibold">{{ $ds->pelanggan->nama_lengkap ?? '-' }}</div>
                                <small class="text-muted">{{ $ds->id_pelanggan }}</small>
                            </td>
                            <td>
                                <span class="badge bg-dark">{{ $ds->no_plat }}</span>
                                <div class="small text-muted">{{ $ds->kendaraan->jenis_kendaraan ?? '-' }}</div>
                            </td>
                            <td>{{ $ds->keluhan_kendaraan }}</td>
                            <td class="text-center pe-4">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditDaftarService{{ $safeId }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('daftar-service.destroy', $ds->id_servis) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pendaftaran servis {{ $ds->id_servis }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEditDaftarService{{ $safeId }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('daftar-service.update', $ds->id_servis) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Edit Pendaftaran Service</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">ID Servis</label>
                                                <input type="text" class="form-control bg-light" value="{{ $ds->id_servis }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Pilih Pelanggan (ID Pelanggan)</label>
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
                                                <label class="form-label fw-semibold">Nama Lengkap Pelanggan (Auto-Fill)</label>
                                                <input type="text" id="editNamaPelanggan{{ $safeId }}" class="form-control bg-light" value="{{ $ds->pelanggan->nama_lengkap ?? '' }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Pilih Kendaraan (No. Plat)</label>
                                                <select name="no_plat" class="form-select" required>
                                                    <option value="">-- Pilih No. Plat --</option>
                                                    @foreach($kendaraans as $k)
                                                        <option value="{{ $k->no_plat }}" {{ $ds->no_plat === $k->no_plat ? 'selected' : '' }}>
                                                            {{ $k->no_plat }} ({{ $k->jenis_kendaraan }} - {{ $k->nama_pemilik }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Tanggal Servis</label>
                                                <input type="date" name="tanggal_servis" class="form-control" value="{{ $ds->tanggal_servis }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Keluhan Kendaraan</label>
                                                <textarea name="keluhan_kendaraan" class="form-control" rows="3" required>{{ $ds->keluhan_kendaraan }}</textarea>
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
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data pendaftaran service.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahDaftarService" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('daftar-service.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Pendaftaran Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">ID Servis</label>
                        <input type="text" name="id_servis" class="form-control" placeholder="Contoh: SRV-001" required maxlength="20">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Pelanggan (ID Pelanggan)</label>
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
                        <label class="form-label fw-semibold">Nama Lengkap Pelanggan (Otomatis)</label>
                        <input type="text" id="tambahNamaPelanggan" class="form-control bg-light" placeholder="Otomatis terisi saat ID Pelanggan dipilih" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Kendaraan (No. Plat)</label>
                        <select name="no_plat" class="form-select" required>
                            <option value="">-- Pilih No. Plat --</option>
                            @foreach($kendaraans as $k)
                                <option value="{{ $k->no_plat }}">
                                    {{ $k->no_plat }} ({{ $k->jenis_kendaraan }} - {{ $k->nama_pemilik }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Servis</label>
                        <input type="date" name="tanggal_servis" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keluhan Kendaraan</label>
                        <textarea name="keluhan_kendaraan" class="form-control" rows="3" placeholder="Jelaskan keluhan kendaraan..." required></textarea>
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
    });
</script>
@endpush
