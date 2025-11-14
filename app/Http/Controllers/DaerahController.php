<?php

namespace App\Http\Controllers;

use App\Models\Daerah;
use Illuminate\Http\Request;

class DaerahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menampilkan halaman data daerah pengiriman
        $daerah = Daerah::all();
        return view('dashboard.data.index', compact('daerah'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_daerah' => 'required|string|max:50|unique:daerah,kode_daerah',
            'nama' => 'required|string|max:255',
        ]);

        Daerah::create([
            'kode_daerah' => $request->kode_daerah,
            'nama' => ucwords(strtolower($request->nama)),
        ]);

        return redirect()->route('dashboard.daerah')->with('success', 'Daerah berhasil ditambahkan.');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_daerah)
    {
        $request->validate([
            'kode_daerah' => 'required|string|max:50|unique:daerah,kode_daerah,' . $id_daerah . ',id_daerah',
            'nama' => 'required|string|max:255',
        ]);

        $daerah = Daerah::findOrFail($id_daerah);
        $daerah->update([
            'kode_daerah' => $request->kode_daerah,
            'nama' => ucwords(strtolower($request->nama)),
        ]);

        return redirect()->route('dashboard.daerah')->with('success', 'Daerah berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_daerah)
    {
        $daerah = Daerah::findOrFail($id_daerah);
        $daerah->delete();

        return redirect()->route('dashboard.daerah')->with('success', 'Daerah berhasil dihapus.');
    }
}
