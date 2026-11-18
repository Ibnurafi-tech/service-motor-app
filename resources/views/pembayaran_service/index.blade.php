@extends('layouts.app')

@section('title', 'Pembayaran Servis - MotorCare')
@section('page_title', 'Transaksi Pembayaran Servis')
@section('page_subtitle', 'Kelola pembayaran kasir, metode tunai/non-tunai, dan cetak bukti pembayaran')

@section('content')
<div class="card">
    <div class="card-header py-3 px-4 d-flex flex-wrap gap-3 justify-content-between align-items-center">
        <div class="d-flex flex-wrap gap-2 align-items-center flex-grow-1">
            <div class="input-group" style="max-width: 320px;">
                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" id="searchPembayaran" class="form-control border-start-0 ps-0" placeholder="Cari ID servis, pelanggan, keterangan...">
            </div>
            <select id="filterMetodeBayar" class="form-select" style="max-width: 210px;">
                <option value="">Semua Metode Bayar</option>
                <option value="cash / tunai">Cash / Tunai</option>
                <option value="non tunai">Non Tunai</option>
            </select>
        </div>
        <button class="btn btn-mc-orange px-3" data-bs-toggle="modal" data-bs-target="#modalTambahPembayaran">
            <i class="bi bi-plus-lg me-1"></i> Transaksi Pembayaran Baru
        </button>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">ID Servis & Pelanggan</th>
                        <th>Tanggal Transaksi</th>
                        <th>Jumlah Biaya Servis</th>
                        <th>Jenis Pembayaran</th>
                        <th>Keterangan</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayarans as $pb)
                        <tr class="pembayaran-row"
                            data-search="{{ strtolower($pb->id_servis . ' ' . ($pb->daftarService->pelanggan->nama_lengkap ?? '') . ' ' . ($pb->daftarService->no_plat ?? '') . ' ' . ($pb->keterangan ?? '')) }}"
                            data-metode="{{ strtolower($pb->jenis_pembayaran) }}">
                            <td class="ps-4">
                                <a href="{{ route('detail-servis.show', $pb->id_servis) }}" class="fw-bold text-mc-navy text-decoration-none">
                                    {{ $pb->id_servis }}
                                </a>
                                <div class="small text-muted">{{ $pb->daftarService->pelanggan->nama_lengkap ?? '-' }} ({{ $pb->daftarService->no_plat ?? '-' }})</div>
                            </td>
                            <td class="text-secondary">{{ $pb->created_at ? $pb->created_at->format('d M Y, H:i') : '-' }}</td>
                            <td>
                                <span class="fw-bold text-mc-navy fs-6">Rp {{ number_format($pb->jumlah_biaya, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                @if($pb->jenis_pembayaran === 'Cash / Tunai')
                                    <span class="badge badge-soft-success"><i class="bi bi-cash-stack me-1"></i>Cash / Tunai</span>
                                @else
                                    <span class="badge badge-soft-navy"><i class="bi bi-credit-card-2-back me-1"></i>Non Tunai</span>
                                @endif
                            </td>
                            <td style="max-width: 240px;">
                                <span class="text-secondary">{{ $pb->keterangan ?: 'Lunas' }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('detail-servis.show', $pb->id_servis) }}?print=1" class="btn btn-sm btn-outline-secondary" title="Cetak Bukti Pembayaran">
                                        <i class="bi bi-printer"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-warning" title="Edit Pembayaran" data-bs-toggle="modal" data-bs-target="#modalEditPembayaran{{ $pb->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('pembayaran-service.destroy', $pb->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus transaksi pembayaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-start-0" title="Hapus Pembayaran">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Edit Pembayaran -->
                        <div class="modal fade" id="modalEditPembayaran{{ $pb->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('pembayaran-service.update', $pb->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold text-mc-navy">Edit Transaksi Pembayaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small">ID Servis Pelanggan</label>
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
                                                <label class="form-label fw-semibold small">Jumlah Biaya Servis (Rp)</label>
                                                <input type="number" name="jumlah_biaya" class="form-control" value="{{ (int) $pb->jumlah_biaya }}" min="0" step="1" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small d-block">Jenis Pembayaran</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check border rounded-3 px-3 py-2 flex-fill">
                                                        <input class="form-check-input ms-0 me-2" type="radio" name="jenis_pembayaran" id="editCash{{ $pb->id }}" value="Cash / Tunai" {{ $pb->jenis_pembayaran === 'Cash / Tunai' ? 'checked' : '' }} required>
                                                        <label class="form-check-label fw-medium" for="editCash{{ $pb->id }}">Cash / Tunai</label>
                                                    </div>
                                                    <div class="form-check border rounded-3 px-3 py-2 flex-fill">
                                                        <input class="form-check-input ms-0 me-2" type="radio" name="jenis_pembayaran" id="editNonTunai{{ $pb->id }}" value="Non Tunai" {{ $pb->jenis_pembayaran === 'Non Tunai' ? 'checked' : '' }} required>
                                                        <label class="form-check-label fw-medium" for="editNonTunai{{ $pb->id }}">Non Tunai</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label fw-semibold small">Keterangan</label>
                                                <textarea name="keterangan" class="form-control" rows="2">{{ $pb->keterangan }}</textarea>
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
                                <i class="bi bi-cash-coin fs-2 d-block mb-2"></i>
                                Belum ada riwayat transaksi pembayaran servis.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Pembayaran -->
<div class="modal fade" id="modalTambahPembayaran" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('pembayaran-service.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title fw-bold text-mc-navy">Form Transaksi Pembayaran</h5>
                        <small class="text-muted">Proses pembayaran servis dan terbitkan bukti lunas</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">ID Servis Pelanggan</label>
                        <select name="id_servis" id="selectServisBayar" class="form-select" required>
                            <option value="" data-pelanggan="-" data-plat="-" data-keluhan="-">-- Pilih ID Servis --</option>
                            @foreach($daftarServices as $srv)
                                <option value="{{ $srv->id_servis }}"
                                        data-pelanggan="{{ $srv->pelanggan->nama_lengkap ?? '-' }}"
                                        data-plat="{{ $srv->no_plat }}"
                                        data-keluhan="{{ $srv->keluhan_kendaraan }}">
                                    {{ $srv->id_servis }} - {{ $srv->pelanggan->nama_lengkap ?? '-' }} ({{ $srv->no_plat }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Ringkasan Biaya Sebelum Pembayaran -->
                    <div class="p-3 rounded-3 border bg-light mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small fw-bold text-mc-navy text-uppercase">Ringkasan Tagihan Servis</span>
                            <span class="badge badge-soft-orange" id="summaryPlat">-</span>
                        </div>
                        <div class="small text-secondary mb-2">Pelanggan: <strong class="text-dark" id="summaryPelanggan">-</strong></div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <span class="small text-muted">Total Estimasi Bayar:</span>
                            <span class="fs-5 fw-bold text-mc-navy" id="summaryTotalBiaya">Rp 0</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Jumlah Biaya Servis (Rp)</label>
                        <input type="number" name="jumlah_biaya" id="inputJumlahBiaya" class="form-control" placeholder="Contoh: 150000" min="0" step="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small d-block">Jenis Pembayaran</label>
                        <div class="d-flex gap-3">
                            <div class="form-check border rounded-3 px-3 py-2 flex-fill">
                                <input class="form-check-input ms-0 me-2" type="radio" name="jenis_pembayaran" id="tambahCash" value="Cash / Tunai" checked required>
                                <label class="form-check-label fw-medium" for="tambahCash"><i class="bi bi-cash me-1 text-success"></i>Cash / Tunai</label>
                            </div>
                            <div class="form-check border rounded-3 px-3 py-2 flex-fill">
                                <input class="form-check-input ms-0 me-2" type="radio" name="jenis_pembayaran" id="tambahNonTunai" value="Non Tunai" required>
                                <label class="form-check-label fw-medium" for="tambahNonTunai"><i class="bi bi-credit-card me-1 text-mc-navy"></i>Non Tunai</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold small">Keterangan (Opsional)</label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan pembayaran lunas, transfer BCA/QRIS, dll..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-mc-orange px-4">
                        <i class="bi bi-check2-circle me-1"></i> Proses Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectServis = document.getElementById('selectServisBayar');
        const inputBiaya = document.getElementById('inputJumlahBiaya');
        const summaryPelanggan = document.getElementById('summaryPelanggan');
        const summaryPlat = document.getElementById('summaryPlat');
        const summaryTotal = document.getElementById('summaryTotalBiaya');

        selectServis?.addEventListener('change', function () {
            const opt = this.options[this.selectedIndex];
            summaryPelanggan.textContent = opt.getAttribute('data-pelanggan') || '-';
            summaryPlat.textContent = opt.getAttribute('data-plat') || '-';
        });

        inputBiaya?.addEventListener('input', function () {
            const val = parseInt(this.value || '0', 10);
            summaryTotal.textContent = 'Rp ' + val.toLocaleString('id-ID');
        });

        const searchInput = document.getElementById('searchPembayaran');
        const filterMetode = document.getElementById('filterMetodeBayar');
        const rows = document.querySelectorAll('.pembayaran-row');

        function filterTable() {
            const q = (searchInput?.value || '').toLowerCase().trim();
            const met = (filterMetode?.value || '').toLowerCase().trim();

            rows.forEach(row => {
                const matchSearch = !q || row.dataset.search.includes(q);
                const matchMet = !met || row.dataset.metode === met;
                row.style.display = (matchSearch && matchMet) ? '' : 'none';
            });
        }

        searchInput?.addEventListener('input', filterTable);
        filterMetode?.addEventListener('change', filterTable);
    });
</script>
@endpush
