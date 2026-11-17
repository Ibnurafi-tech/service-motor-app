<?php

namespace App\Http\Controllers;

use App\Models\DaftarService;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class DaftarServiceController extends Controller
{
    public function index()
    {
        $daftarServices = DaftarService::with(['pelanggan', 'kendaraan'])->latest()->get();
        $kendaraans = Kendaraan::all();
        $pelanggans = Pelanggan::all();

        return view('daftar_service.index', compact('daftarServices', 'kendaraans', 'pelanggans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_servis'         => 'required|unique:daftar_services,id_servis|max:20',
            'no_plat'           => 'required|exists:kendaraans,no_plat',
            'id_pelanggan'      => 'required|exists:pelanggans,id_pelanggan',
            'keluhan_kendaraan' => 'required',
            'tanggal_servis'    => 'required|date',
        ]);

        DaftarService::create($request->all());
        return redirect()->route('daftar-service.index')->with('success', 'Pendaftaran service berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'no_plat'           => 'required|exists:kendaraans,no_plat',
            'id_pelanggan'      => 'required|exists:pelanggans,id_pelanggan',
            'keluhan_kendaraan' => 'required',
            'tanggal_servis'    => 'required|date',
        ]);

        $service = DaftarService::findOrFail($id);
        $service->update($request->except('id_servis'));
        return redirect()->route('daftar-service.index')->with('success', 'Pendaftaran service berhasil diperbarui!');
    }

    public function destroy($id)
    {
        DaftarService::findOrFail($id)->delete();
        return redirect()->route('daftar-service.index')->with('success', 'Pendaftaran service berhasil dihapus!');
    }
}