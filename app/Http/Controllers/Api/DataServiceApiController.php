<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataService;
use Illuminate\Http\Request;

class DataServiceApiController extends Controller
{
    public function index()
    {
        $data = DataService::with('daftarService.pelanggan')->latest()->get();
        return response()->json([
            'status'  => true,
            'message' => 'Data pengerjaan service berhasil diambil',
            'data'    => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_servis'           => 'required|exists:daftar_services,id_servis',
            'estimasi_service'    => 'required|max:50',
            'nama_mekanik'        => 'required|max:100',
            'sparepart_pengganti' => 'nullable',
        ]);

        $dataService = DataService::create($validated)->load('daftarService');

        return response()->json([
            'status'  => true,
            'message' => 'Data pengerjaan service berhasil ditambahkan',
            'data'    => $dataService
        ], 201);
    }

    public function show($id)
    {
        $dataService = DataService::with('daftarService.pelanggan')->find($id);

        if (!$dataService) {
            return response()->json([
                'status'  => false,
                'message' => 'Data pengerjaan service tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Detail pengerjaan service berhasil diambil',
            'data'    => $dataService
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $dataService = DataService::find($id);

        if (!$dataService) {
            return response()->json([
                'status'  => false,
                'message' => 'Data pengerjaan service tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'id_servis'           => 'required|exists:daftar_services,id_servis',
            'estimasi_service'    => 'required|max:50',
            'nama_mekanik'        => 'required|max:100',
            'sparepart_pengganti' => 'nullable',
        ]);

        $dataService->update($validated);
        $dataService->load('daftarService');

        return response()->json([
            'status'  => true,
            'message' => 'Data pengerjaan service berhasil diperbarui',
            'data'    => $dataService
        ], 200);
    }

    public function destroy($id)
    {
        $dataService = DataService::find($id);

        if (!$dataService) {
            return response()->json([
                'status'  => false,
                'message' => 'Data pengerjaan service tidak ditemukan'
            ], 404);
        }

        $dataService->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Data pengerjaan service berhasil dihapus'
        ], 200);
    }
}
