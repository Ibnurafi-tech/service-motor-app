<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::latest()->get();
        return view('kendaraan.index', compact('kendaraans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_plat'         => 'required|unique:kendaraans,no_plat|max:20',
            'jenis_kendaraan' => 'required|in:Matic,Manual Transmisi',
            'no_stnk'         => 'required|max:30',
            'tahun_pembuatan' => 'required|digits:4',
            'nama_pemilik'    => 'required|max:100',
            'warna_kendaraan' => 'required|max:30',
        ]);

        Kendaraan::create($request->all());
        return redirect()->route('kendaraan.index')->with('success', 'Data kendaraan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_kendaraan' => 'required|in:Matic,Manual Transmisi',
            'no_stnk'         => 'required|max:30',
            'tahun_pembuatan' => 'required|digits:4',
            'nama_pemilik'    => 'required|max:100',
            'warna_kendaraan' => 'required|max:30',
        ]);

        $kendaraan = Kendaraan::findOrFail($id);
        $kendaraan->update($request->except('no_plat'));
        return redirect()->route('kendaraan.index')->with('success', 'Data kendaraan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Kendaraan::findOrFail($id)->delete();
        return redirect()->route('kendaraan.index')->with('success', 'Data kendaraan berhasil dihapus!');
    }
}