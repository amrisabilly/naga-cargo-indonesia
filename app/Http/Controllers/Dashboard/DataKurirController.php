<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DataKurirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kurirs = User::where('role', 'Kurir')->get();
        return view('dashboard.kurir.index', compact('kurirs'));
    }


    public function create()
    {
        return view('dashboard.kurir.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:3',
            'no_hp' => 'required|string|max:15',
            'id_daerah' => 'nullable|integer',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        try {
            User::create([
                'role' => 'Kurir',
                'nama' => $request->nama,
                'username' => $request->username,
                'password' => $request->password,
                'no_hp' => $request->no_hp,
                'id_daerah' => $request->id_daerah,
                'status' => $request->status,
            ]);

            return redirect()->route('dashboard.kurir.index')->with('success', 'Kurir berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menambahkan kurir: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kurir = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $kurir->id,
            'password' => 'nullable|string|min:6',
            'no_hp' => 'required|string|max:15',
            'id_daerah' => 'nullable|integer',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        try {
            $kurir->update([
                'nama' => $request->nama,
                'username' => $request->username,
                'password' => $request->password ,
                'no_hp' => $request->no_hp,
                'id_daerah' => $request->id_daerah,
                'status' => $request->status,
            ]);

            return redirect()->route('dashboard.kurir.index')->with('success', 'Kurir berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui kurir: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kurir = User::findOrFail($id);
        $kurir->delete();

        //return redirect()->route('dashboard.akun.index')->with('success', 'Kurir berhasil dihapus.');
    }
}