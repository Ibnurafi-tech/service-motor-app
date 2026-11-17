<?php

namespace App\Http\Controllers;

use App\Models\PembayaranService;
use App\Models\DaftarService;
use Illuminate\Http\Request;

class PembayaranServiceController extends Controller
{
    public function index()
    {
        $pembayarans = PembayaranService::with('daftarService.pelanggan')->latest()->get();
        $daftarServices = DaftarService::with('pelanggan')->get();

        return view('pembayaran_service.index', compact('pembayarans', 'daftarServices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_servis'        => 'required|exists:daftar_services,id_servis',
            'jumlah_biaya'     => 'required|numeric|min:0',
            'jenis_pembayaran' => 'required|in:Cash / Tunai,Non Tunai',
            'keterangan'       => 'nullable',
        ]);

        PembayaranService::create($request->all());
        return redirect()->route('pembayaran-service.index')->with('success', 'Data pembayaran berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_servis'        => 'required|exists:daftar_services,id_servis',
            'jumlah_biaya'     => 'required|numeric|min:0',
            'jenis_pembayaran' => 'required|in:Cash / Tunai,Non Tunai',
            'keterangan'       => 'nullable',
        ]);

        $pembayaran = PembayaranService::findOrFail($id);
        $pembayaran->update($request->all());
        return redirect()->route('pembayaran-service.index')->with('success', 'Data pembayaran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        PembayaranService::findOrFail($id)->delete();
        return redirect()->route('pembayaran-service.index')->with('success', 'Data pembayaran berhasil dihapus!');
    }
}