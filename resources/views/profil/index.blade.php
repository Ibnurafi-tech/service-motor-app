@extends('layouts.app')

@section('title', 'Profil & Pengaturan - MotorCare')
@section('page_title', 'Profil & Pengaturan Akun')
@section('page_subtitle', 'Kelola informasi akun petugas, peran akses bengkel, dan pengaturan sesi')

@section('content')
@php
    $user = session('mc_user', [
        'name'          => 'Admin Bengkel',
        'email'         => 'admin@motorcare.id',
        'role'          => 'Kepala Administrasi',
        'phone'         => '0812-3456-7890',
        'workshop_name' => 'MotorCare Workshop Pusat',
        'workshop_addr' => 'Jl. Medan - Banda Aceh No. 12, Lhokseumawe',
    ]);
@endphp

<div class="row g-4">
    <!-- Kartu Informasi Akun -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-body p-4 text-center d-flex flex-column justify-content-between">
                <div>
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center fw-bold text-white fs-2 mb-3" style="width: 82px; height: 82px; background-color: var(--mc-navy);">
                        {{ strtoupper(substr($user['name'] ?? 'AB', 0, 2)) }}
                    </div>
                    <h5 class="fw-bold text-mc-navy mb-1">{{ $user['name'] ?? 'Admin Bengkel' }}</h5>
                    <span class="badge badge-soft-orange px-3 py-1.5 mb-3">{{ $user['role'] ?? 'Kepala Administrasi' }}</span>
                    <p class="text-secondary small mb-4">{{ $user['email'] ?? 'admin@motorcare.id' }}</p>

                    <div class="text-start p-3 rounded-3 bg-light border small">
                        <div class="mb-2">
                            <div class="text-muted">Unit Bengkel</div>
                            <div class="fw-semibold text-dark">{{ $user['workshop_name'] ?? 'MotorCare Workshop Pusat' }}</div>
                        </div>
                        <div class="mb-2">
                            <div class="text-muted">Kontak Petugas</div>
                            <div class="fw-semibold text-dark">{{ $user['phone'] ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="text-muted">Alamat Bengkel</div>
                            <div class="fw-semibold text-dark">{{ $user['workshop_addr'] ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <form action="{{ route('profil.logout') }}" method="POST" onsubmit="return confirm('Keluar dan reset sesi profil saat ini?')">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 fw-semibold">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout / Reset Sesi Akun
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Edit Profil & Pengaturan -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header py-3 px-4">
                <h6 class="mb-0 fw-bold text-mc-navy"><i class="bi bi-sliders me-2 text-mc-orange"></i>Edit Profil & Pengaturan Operasional Bengkel</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('profil.update') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <div class="small fw-bold text-uppercase text-mc-navy mb-3 pb-2 border-bottom">1. Informasi Akun Pengguna</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Nama Lengkap Petugas</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user['name'] ?? '') }}" required maxlength="100">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Peran / Jabatan</label>
                                <select name="role" class="form-select" required>
                                    @foreach(['Pemilik Bengkel', 'Kepala Administrasi', 'Admin Bengkel', 'Kasir', 'Kepala Mekanik'] as $roleOption)
                                        <option value="{{ $roleOption }}" {{ ($user['role'] ?? '') === $roleOption ? 'selected' : '' }}>
                                            {{ $roleOption }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Email Akun</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user['email'] ?? '') }}" required maxlength="100">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Nomor HP / WhatsApp</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user['phone'] ?? '') }}" maxlength="20">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="small fw-bold text-uppercase text-mc-navy mb-3 pb-2 border-bottom">2. Pengaturan Identitas Bengkel (Untuk Invoice)</div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-semibold small">Nama Bengkel</label>
                                <input type="text" name="workshop_name" class="form-control" value="{{ old('workshop_name', $user['workshop_name'] ?? '') }}" required maxlength="100">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold small">Alamat Lengkap Bengkel</label>
                                <textarea name="workshop_addr" class="form-control" rows="2" maxlength="255">{{ old('workshop_addr', $user['workshop_addr'] ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('dashboard') }}" class="btn btn-light border px-4">Batal</a>
                        <button type="submit" class="btn btn-mc-orange px-4">
                            <i class="bi bi-check2-circle me-1"></i> Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
