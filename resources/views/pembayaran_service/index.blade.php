@extends('layouts.app')

@section('title', 'Pembayaran Service - Service Motor App')
@section('page_title', 'Transaksi Pembayaran Service')

@section('content')
<div class="card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold"><i class="bi bi-cash-coin me-2 text-primary"></i>Riwayat Pembayaran Service</h6>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahPembayaran">
            <i class="bi bi-plus-circle me-1"></i> Tambah Pembayaran
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>ID Servis & Pelanggan</th>
                        <th>Jumlah Biaya</th>
                        <th>Jenis Pembayaran</th>
                        <th>Keterangan</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayarans as $index => $pb)
                        <tr>
                            <td class="ps-4">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-semibold text-primary">{{ $pb->id_servis }}</div>
                                <small class="text-muted">{{ $pb->daftarService->pelanggan->nama_lengkap ?? '-' }}</small>
                            </td>
                            <td class="fw-bold text-success">Rp {{ number_format($pb->jumlah_biaya, 0, ',', '.') }}</td>
                            <td>
                                @if($pb->jenis_pembayaran === 'Cash / Tunai')
                                    <span class="badge bg-success"><i class="bi bi-cash me-1"></i>Cash / Tunai</span>
                                @else
                                    <span class="badge bg-primary"><i class="bi bi-credit-card me-1"></i>Non Tunai</span>
                                @endif
                            </td>
                            <td>{{ $pb->keterangan ?: '-' }}</td>
                            <td class="text-center pe-4">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditPembayaran{{ $pb->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('pembayaran-service.destroy', $pb->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data pembayaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEditPembayaran{{ $pb->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('pembayaran-service.update', $pb->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Edit Pembayaran Service</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Pilih ID Servis</label>
                                                <select name="id_servis" class="form-select" required>
                                                    <option value="">-- Pilih ID Servis --</option>
                                                    @foreach($daftarServices as $srv)
                                                        <option value="{{ $srv->id_servis }}" {{ $pb->id_servis === $srv->id_servis ? 'selected' : '' }}>
                                                            {{ $srv->id_servis }} - {{ $srv->pelanggan->nama_lengkap ?? '-' }} ({{ $srv->no_plat }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Jumlah Biaya (Rp)</label>
                                                <input type="number" name="jumlah_biaya" class="form-control" value="{{ (int) $pb->jumlah_biaya }}" min="0" step="1" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold d-block">Jenis Pembayaran</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="jenis_pembayaran" id="editCash{{ $pb->id }}" value="Cash / Tunai" {{ $pb->jenis_pembayaran === 'Cash / Tunai' ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="editCash{{ $pb->id }}">Cash / Tunai</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="jenis_pembayaran" id="editNonTunai{{ $pb->id }}" value="Non Tunai" {{ $pb->jenis_pembayaran === 'Non Tunai' ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="editNonTunai{{ $pb->id }}">Non Tunai</label>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Keterangan (Opsional)</label>
                                                <textarea name="keterangan" class="form-control" rows="3">{{ $pb->keterangan }}</textarea>
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
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data pembayaran service.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahPembayaran" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('pembayaran-service.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Pembayaran Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih ID Servis</label>
                        <select name="id_servis" class="form-select" required>
                            <option value="">-- Pilih ID Servis --</option>
                            @foreach($daftarServices as $srv)
                                <option value="{{ $srv->id_servis }}">
                                    {{ $srv->id_servis }} - {{ $srv->pelanggan->nama_lengkap ?? '-' }} ({{ $srv->no_plat }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jumlah Biaya (Rp)</label>
                        <input type="number" name="jumlah_biaya" class="form-control" placeholder="Contoh: 150000" min="0" step="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold d-block">Jenis Pembayaran</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_pembayaran" id="tambahCash" value="Cash / Tunai" checked required>
                            <label class="form-check-label" for="tambahCash">Cash / Tunai</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_pembayaran" id="tambahNonTunai" value="Non Tunai" required>
                            <label class="form-check-label" for="tambahNonTunai">Non Tunai</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keterangan (Opsional)</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Catatan pembayaran, lunas, transfer bank, dll..."></textarea>
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
