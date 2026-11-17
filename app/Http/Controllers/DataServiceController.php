<?php

namespace App\Http\Controllers;

use App\Models\DataService;
use App\Models\DaftarService;
use Illuminate\Http\Request;

class DataServiceController extends Controller
{
    public function index()
    {
        $dataServices = DataService::with('daftarService.pelanggan')->latest()->get();
        $daftarServices = DaftarService::with('pelanggan')->get();

        return view('data_service.index', compact('dataServices', 'daftarServices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_servis'           => 'required|exists:daftar_services,id_servis',
            'estimasi_service'    => 'required|max:50',
            'nama_mekanik'        => 'required|max:100',
            'sparepart_pengganti' => 'nullable',
        ]);

        DataService::create($request->all());
        return redirect()->route('data-service.index')->with('success', 'Data pengerjaan service berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_servis'           => 'required|exists:daftar_services,id_servis',
            'estimasi_service'    => 'required|max:50',
            'nama_mekanik'        => 'required|max:100',
            'sparepart_pengganti' => 'nullable',
        ]);

        $dataService = DataService::findOrFail($id);
        $dataService->update($request->all());
        return redirect()->route('data-service.index')->with('success', 'Data pengerjaan service berhasil diperbarui!');
    }

    public function destroy($id)
    {
        DataService::findOrFail($id)->delete();
        return redirect()->route('data-service.index')->with('success', 'Data pengerjaan service berhasil dihapus!');
    }
}