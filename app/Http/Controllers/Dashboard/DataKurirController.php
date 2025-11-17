<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Daerah;
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
        $kurirs = User::with('daerah')->where('role', 'Kurir')->get();
        return view('dashboard.kurir.index', compact('kurirs'));
    }


    public function create()
    {
        // fetch data daerah
        $daerah = Daerah::get();
        return view('dashboard.kurir.create', compact('daerah'));
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

            return redirect()->route('dashboard.data-kurir.index')->with('success', 'Kurir berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menambahkan kurir: ' . $e->getMessage()]);
        }
    }

    public function edit($id_user)
    {
        // fetch data kurir dan daerah
        $kurir = User::where('id_user', $id_user)->where('role', 'Kurir')->first();
        $daerah = Daerah::get();
        return view('dashboard.kurir.edit', compact('kurir', 'daerah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_user)
    {
        // dd($request, $id_user);

        $kurir = User::where('id_user', $id_user)->where('role', 'Kurir')->first();

        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|min:6', // nullable!
            'no_hp' => 'required|string|max:15',
            'id_daerah' => 'nullable|integer',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        try {
            $data = [
                'nama' => $request->nama,
                'username' => $request->username,
                'no_hp' => $request->no_hp,
                'id_daerah' => $request->id_daerah,
                'status' => $request->status,
            ];

            // Update password hanya jika diisi
            if ($request->filled('password')) {
                $data['password'] = $request->password;
            }

            $kurir->update($data);

            return redirect()->route('dashboard.data-kurir.index')->with('success', 'Kurir berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui kurir: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_user)
    {
        $kurir = User::where('id_user', $id_user)->where('role', 'Kurir')->firstOrFail();
        $kurir->delete();

        return redirect()->route('dashboard.data-kurir.index')->with('success', 'Kurir berhasil dihapus.');
    }
}
