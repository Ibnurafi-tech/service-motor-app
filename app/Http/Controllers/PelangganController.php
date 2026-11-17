<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::latest()->get();
        return view('pelanggan.index', compact('pelanggans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'required|unique:pelanggans,id_pelanggan|max:20',
            'nama_lengkap' => 'required|max:100',
            'no_hp'        => 'required|max:15',
            'alamat'       => 'required',
            'pekerjaan'    => 'required|max:50',
        ]);

        Pelanggan::create($request->all());
        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap' => 'required|max:100',
            'no_hp'        => 'required|max:15',
            'alamat'       => 'required',
            'pekerjaan'    => 'required|max:50',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($request->except('id_pelanggan'));
        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Pelanggan::findOrFail($id)->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil dihapus!');
    }
}