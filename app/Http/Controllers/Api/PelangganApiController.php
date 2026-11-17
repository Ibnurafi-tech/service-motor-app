<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganApiController extends Controller
{
    public function index()
    {
        $data = Pelanggan::latest()->get();
        return response()->json([
            'status'  => true,
            'message' => 'Data pelanggan berhasil diambil',
            'data'    => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pelanggan' => 'required|unique:pelanggans,id_pelanggan|max:20',
            'nama_lengkap' => 'required|max:100',
            'no_hp'        => 'required|max:15',
            'alamat'       => 'required',
            'pekerjaan'    => 'required|max:50',
        ]);

        $pelanggan = Pelanggan::create($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Data pelanggan berhasil ditambahkan',
            'data'    => $pelanggan
        ], 201);
    }

    public function show($id)
    {
        $pelanggan = Pelanggan::with('daftarServices')->find($id);

        if (!$pelanggan) {
            return response()->json([
                'status'  => false,
                'message' => 'Data pelanggan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Detail pelanggan berhasil diambil',
            'data'    => $pelanggan
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::find($id);

        if (!$pelanggan) {
            return response()->json([
                'status'  => false,
                'message' => 'Data pelanggan tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'nama_lengkap' => 'required|max:100',
            'no_hp'        => 'required|max:15',
            'alamat'       => 'required',
            'pekerjaan'    => 'required|max:50',
        ]);

        $pelanggan->update($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Data pelanggan berhasil diperbarui',
            'data'    => $pelanggan
        ], 200);
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::find($id);

        if (!$pelanggan) {
            return response()->json([
                'status'  => false,
                'message' => 'Data pelanggan tidak ditemukan'
            ], 404);
        }

        $pelanggan->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Data pelanggan berhasil dihapus'
        ], 200);
    }
}
