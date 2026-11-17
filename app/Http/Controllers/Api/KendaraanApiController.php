<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanApiController extends Controller
{
    public function index()
    {
        $data = Kendaraan::latest()->get();
        return response()->json([
            'status'  => true,
            'message' => 'Data kendaraan berhasil diambil',
            'data'    => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_plat'         => 'required|unique:kendaraans,no_plat|max:20',
            'jenis_kendaraan' => 'required|in:Matic,Manual Transmisi',
            'no_stnk'         => 'required|max:30',
            'tahun_pembuatan' => 'required|digits:4',
            'nama_pemilik'    => 'required|max:100',
            'warna_kendaraan' => 'required|max:30',
        ]);

        $kendaraan = Kendaraan::create($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Data kendaraan berhasil ditambahkan',
            'data'    => $kendaraan
        ], 201);
    }

    public function show($id)
    {
        $kendaraan = Kendaraan::with('daftarServices')->find($id);

        if (!$kendaraan) {
            return response()->json([
                'status'  => false,
                'message' => 'Data kendaraan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Detail kendaraan berhasil diambil',
            'data'    => $kendaraan
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $kendaraan = Kendaraan::find($id);

        if (!$kendaraan) {
            return response()->json([
                'status'  => false,
                'message' => 'Data kendaraan tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'jenis_kendaraan' => 'required|in:Matic,Manual Transmisi',
            'no_stnk'         => 'required|max:30',
            'tahun_pembuatan' => 'required|digits:4',
            'nama_pemilik'    => 'required|max:100',
            'warna_kendaraan' => 'required|max:30',
        ]);

        $kendaraan->update($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Data kendaraan berhasil diperbarui',
            'data'    => $kendaraan
        ], 200);
    }

    public function destroy($id)
    {
        $kendaraan = Kendaraan::find($id);

        if (!$kendaraan) {
            return response()->json([
                'status'  => false,
                'message' => 'Data kendaraan tidak ditemukan'
            ], 404);
        }

        $kendaraan->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Data kendaraan berhasil dihapus'
        ], 200);
    }
}
