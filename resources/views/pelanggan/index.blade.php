@extends('layouts.app')

@section('title', 'Data Pelanggan - Service Motor App')
@section('page_title', 'Manajemen Data Pelanggan')

@section('content')
<div class="card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold"><i class="bi bi-people me-2 text-primary"></i>Daftar Pelanggan</h6>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPelanggan">
            <i class="bi bi-plus-circle me-1"></i> Tambah Pelanggan
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID Pelanggan</th>
                        <th>Nama Lengkap</th>
                        <th>No. HP</th>
                        <th>Pekerjaan</th>
                        <th>Alamat</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggans as $p)
                        <tr>
                            <td class="ps-4 fw-semibold text-primary">{{ $p->id_pelanggan }}</td>
                            <td>{{ $p->nama_lengkap }}</td>
                            <td>{{ $p->no_hp }}</td>
                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $p->pekerjaan }}</span></td>
                            <td>{{ $p->alamat }}</td>
                            <td class="text-center pe-4">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditPelanggan{{ $p->id_pelanggan }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('pelanggan.destroy', $p->id_pelanggan) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data pelanggan {{ $p->nama_lengkap }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEditPelanggan{{ $p->id_pelanggan }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('pelanggan.update', $p->id_pelanggan) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Edit Pelanggan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">ID Pelanggan</label>
                                                <input type="text" class="form-control bg-light" value="{{ $p->id_pelanggan }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                                <input type="text" name="nama_lengkap" class="form-control" value="{{ $p->nama_lengkap }}" required maxlength="100">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">No. HP</label>
                                                <input type="text" name="no_hp" class="form-control" value="{{ $p->no_hp }}" required maxlength="15">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Pekerjaan</label>
                                                <input type="text" name="pekerjaan" class="form-control" value="{{ $p->pekerjaan }}" required maxlength="50">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Alamat</label>
                                                <textarea name="alamat" class="form-control" rows="3" required>{{ $p->alamat }}</textarea>
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
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data pelanggan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahPelanggan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('pelanggan.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Pelanggan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">ID Pelanggan</label>
                        <input type="text" name="id_pelanggan" class="form-control" placeholder="Contoh: PLG-001" required maxlength="20">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">No. HP</label>
                        <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" required maxlength="15">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pekerjaan</label>
                        <input type="text" name="pekerjaan" class="form-control" placeholder="Contoh: Mahasiswa / Wiraswasta" required maxlength="50">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>
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
