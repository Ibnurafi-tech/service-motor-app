@extends('layouts.app')

@section('title', 'Data Kendaraan - Service Motor App')
@section('page_title', 'Manajemen Data Kendaraan')

@section('content')
<div class="card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold"><i class="bi bi-bicycle me-2 text-primary"></i>Daftar Kendaraan</h6>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKendaraan">
            <i class="bi bi-plus-circle me-1"></i> Tambah Kendaraan
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No. Plat</th>
                        <th>Jenis Kendaraan</th>
                        <th>No. STNK</th>
                        <th>Tahun</th>
                        <th>Nama Pemilik</th>
                        <th>Warna</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kendaraans as $k)
                        @php $safeId = preg_replace('/[^A-Za-z0-9]/', '_', $k->no_plat); @endphp
                        <tr>
                            <td class="ps-4"><span class="badge bg-dark fs-6">{{ $k->no_plat }}</span></td>
                            <td>
                                @if($k->jenis_kendaraan === 'Matic')
                                    <span class="badge bg-info text-dark">Matic</span>
                                @else
                                    <span class="badge bg-warning text-dark">Manual Transmisi</span>
                                @endif
                            </td>
                            <td>{{ $k->no_stnk }}</td>
                            <td>{{ $k->tahun_pembuatan }}</td>
                            <td>{{ $k->nama_pemilik }}</td>
                            <td>{{ $k->warna_kendaraan }}</td>
                            <td class="text-center pe-4">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditKendaraan{{ $safeId }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('kendaraan.destroy', $k->no_plat) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kendaraan {{ $k->no_plat }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEditKendaraan{{ $safeId }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('kendaraan.update', $k->no_plat) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Edit Kendaraan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">No. Plat</label>
                                                <input type="text" class="form-control bg-light" value="{{ $k->no_plat }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold d-block">Jenis Kendaraan</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="jenis_kendaraan" id="editMatic{{ $safeId }}" value="Matic" {{ $k->jenis_kendaraan === 'Matic' ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="editMatic{{ $safeId }}">Matic</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="jenis_kendaraan" id="editManual{{ $safeId }}" value="Manual Transmisi" {{ $k->jenis_kendaraan === 'Manual Transmisi' ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="editManual{{ $safeId }}">Manual Transmisi</label>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">No. STNK</label>
                                                <input type="text" name="no_stnk" class="form-control" value="{{ $k->no_stnk }}" required maxlength="30">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-semibold">Tahun Pembuatan</label>
                                                    <input type="number" name="tahun_pembuatan" class="form-control" value="{{ $k->tahun_pembuatan }}" min="1980" max="2030" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-semibold">Warna Kendaraan</label>
                                                    <input type="text" name="warna_kendaraan" class="form-control" value="{{ $k->warna_kendaraan }}" required maxlength="30">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Nama Pemilik</label>
                                                <input type="text" name="nama_pemilik" class="form-control" value="{{ $k->nama_pemilik }}" required maxlength="100">
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
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data kendaraan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahKendaraan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('kendaraan.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Kendaraan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">No. Plat</label>
                        <input type="text" name="no_plat" class="form-control" placeholder="Contoh: BL 1234 AB" required maxlength="20">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold d-block">Jenis Kendaraan</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kendaraan" id="tambahMatic" value="Matic" checked required>
                            <label class="form-check-label" for="tambahMatic">Matic</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kendaraan" id="tambahManual" value="Manual Transmisi" required>
                            <label class="form-check-label" for="tambahManual">Manual Transmisi</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">No. STNK</label>
                        <input type="text" name="no_stnk" class="form-control" placeholder="Masukkan nomor STNK" required maxlength="30">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tahun Pembuatan</label>
                            <input type="number" name="tahun_pembuatan" class="form-control" placeholder="2023" min="1980" max="2030" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Warna Kendaraan</label>
                            <input type="text" name="warna_kendaraan" class="form-control" placeholder="Hitam / Merah" required maxlength="30">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Pemilik</label>
                        <input type="text" name="nama_pemilik" class="form-control" placeholder="Nama pemilik sesuai STNK" required maxlength="100">
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
