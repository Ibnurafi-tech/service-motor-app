<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DaftarService;
use Illuminate\Http\Request;

class DaftarServiceApiController extends Controller
{
    public function index()
    {
        $data = DaftarService::with(['pelanggan', 'kendaraan'])->latest()->get();
        return response()->json([
            'status'  => true,
            'message' => 'Data pendaftaran service berhasil diambil',
            'data'    => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_servis'         => 'required|unique:daftar_services,id_servis|max:20',
            'no_plat'           => 'required|exists:kendaraans,no_plat',
            'id_pelanggan'      => 'required|exists:pelanggans,id_pelanggan',
            'keluhan_kendaraan' => 'required',
            'tanggal_servis'    => 'required|date',
        ]);

        $service = DaftarService::create($validated)->load(['pelanggan', 'kendaraan']);

        return response()->json([
            'status'  => true,
            'message' => 'Pendaftaran service berhasil ditambahkan',
            'data'    => $service
        ], 201);
    }

    public function show($id)
    {
        $service = DaftarService::with(['pelanggan', 'kendaraan', 'dataServices', 'pembayaranServices'])->find($id);

        if (!$service) {
            return response()->json([
                'status'  => false,
                'message' => 'Data pendaftaran service tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Detail pendaftaran service berhasil diambil',
            'data'    => $service
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $service = DaftarService::find($id);

        if (!$service) {
            return response()->json([
                'status'  => false,
                'message' => 'Data pendaftaran service tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'no_plat'           => 'required|exists:kendaraans,no_plat',
            'id_pelanggan'      => 'required|exists:pelanggans,id_pelanggan',
            'keluhan_kendaraan' => 'required',
            'tanggal_servis'    => 'required|date',
        ]);

        $service->update($validated);
        $service->load(['pelanggan', 'kendaraan']);

        return response()->json([
            'status'  => true,
            'message' => 'Pendaftaran service berhasil diperbarui',
            'data'    => $service
        ], 200);
    }

    public function destroy($id)
    {
        $service = DaftarService::find($id);

        if (!$service) {
            return response()->json([
                'status'  => false,
                'message' => 'Data pendaftaran service tidak ditemukan'
            ], 404);
        }

        $service->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Pendaftaran service berhasil dihapus'
        ], 200);
    }
}
