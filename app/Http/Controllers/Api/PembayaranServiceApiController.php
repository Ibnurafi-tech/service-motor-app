<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PembayaranService;
use Illuminate\Http\Request;

class PembayaranServiceApiController extends Controller
{
    public function index()
    {
        $data = PembayaranService::with('daftarService.pelanggan')->latest()->get();
        return response()->json([
            'status'  => true,
            'message' => 'Data pembayaran service berhasil diambil',
            'data'    => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_servis'        => 'required|exists:daftar_services,id_servis',
            'jumlah_biaya'     => 'required|numeric|min:0',
            'jenis_pembayaran' => 'required|in:Cash / Tunai,Non Tunai',
            'keterangan'       => 'nullable',
        ]);

        $pembayaran = PembayaranService::create($validated)->load('daftarService');

        return response()->json([
            'status'  => true,
            'message' => 'Data pembayaran service berhasil ditambahkan',
            'data'    => $pembayaran
        ], 201);
    }

    public function show($id)
    {
        $pembayaran = PembayaranService::with('daftarService.pelanggan')->find($id);

        if (!$pembayaran) {
            return response()->json([
                'status'  => false,
                'message' => 'Data pembayaran service tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Detail pembayaran service berhasil diambil',
            'data'    => $pembayaran
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $pembayaran = PembayaranService::find($id);

        if (!$pembayaran) {
            return response()->json([
                'status'  => false,
                'message' => 'Data pembayaran service tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'id_servis'        => 'required|exists:daftar_services,id_servis',
            'jumlah_biaya'     => 'required|numeric|min:0',
            'jenis_pembayaran' => 'required|in:Cash / Tunai,Non Tunai',
            'keterangan'       => 'nullable',
        ]);

        $pembayaran->update($validated);
        $pembayaran->load('daftarService');

        return response()->json([
            'status'  => true,
            'message' => 'Data pembayaran service berhasil diperbarui',
            'data'    => $pembayaran
        ], 200);
    }

    public function destroy($id)
    {
        $pembayaran = PembayaranService::find($id);

        if (!$pembayaran) {
            return response()->json([
                'status'  => false,
                'message' => 'Data pembayaran service tidak ditemukan'
            ], 404);
        }

        $pembayaran->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Data pembayaran service berhasil dihapus'
        ], 200);
    }
}
