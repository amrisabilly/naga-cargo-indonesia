<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Daerah;
use App\Models\User;
use Illuminate\Http\Request;

class DataPicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pics = User::with('daerah')->where('role', 'PIC')->get();
        return view('dashboard.akun-pic.index', compact('pics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // fetch data daerah
        $daerah = Daerah::get();
        return view('dashboard.akun-pic.create', compact('daerah'));
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
            'id_daerah' => 'required|integer',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        try {
            User::create([
                'role' => 'PIC',
                'nama' => $request->nama,
                'username' => $request->username,
                'password' => $request->password,
                'no_hp' => $request->no_hp,
                'id_daerah' => $request->id_daerah,
                'status' => $request->status,
            ]);

            return redirect()->route('dashboard.data-pic.index')->with('success', 'PIC berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menambahkan PIC: ' . $e->getMessage()]);
        }
    }


    public function edit($id_user)
    {
        // fetch data kurir dan daerah
        $pic = User::where('id_user', $id_user)->first();
        $daerah = Daerah::get();
        return view('dashboard.akun-pic.edit', compact('pic', 'daerah'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_user)
    {
        $pic = User::where('id_user', $id_user)->first();

        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
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

            if ($request->filled('password')) {
                $data['password'] = $request->password;
            }

            $pic->update($data);

            return redirect()->route('dashboard.data-pic.index')->with('success', 'PIC berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui PIC: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_user)
    {
        $pic = User::where('id_user', $id_user)->firstOrFail();
        $pic->delete();

        return redirect()->route('dashboard.data-pic.index')->with('success', 'PIC berhasil dihapus.');
    }
}
