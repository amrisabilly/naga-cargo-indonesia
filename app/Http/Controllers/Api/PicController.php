<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Daerah;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class PicController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $pic = User::where('username', $request->username)
            ->where('role', 'PIC')
            ->first();

        if (!$pic || $pic->password !== $request->password) {
            return response()->json(['message' => 'Login gagal'], 401);
        }

        // Ambil nama daerah dari relasi
        $nama_daerah = null;
        if ($pic->id_daerah) {
            $daerah = Daerah::find($pic->id_daerah);
            $nama_daerah = $daerah ? $daerah->nama : "Daerah Tidak Ditemukan";
        }

        return response()->json([
            'message' => 'Login berhasil',
            'user' => $pic,
            'nama_daerah' => $nama_daerah
        ]);
    }

    // Simpan data order dari PIC
    public function storeOrder(Request $request)
    {
        $request->validate([
            'AWB' => 'required|string|unique:order,AWB',
            'id_pic' => 'required|exists:users,id_user',  // id PIC
            'tujuan' => 'required|string|max:70',
        ]);

        $pic = User::where('id_user', $request->id_pic)->where('role', 'PIC')->first();
        if (!$pic) {
            return response()->json(['message' => 'PIC tidak ditemukan'], 404);
        }

        $order = Order::create([
            'AWB' => $request->AWB,
            'id_PIC' => $pic->id_user,
            'id_daerah' => $pic->id_daerah,
            'tujuan' => $request->tujuan,
            'status' => 'Proses',
        ]);

        return response()->json(['message' => 'Order berhasil dibuat', 'order' => $order]);
    }

    // Mendapatkan riwayat order untuk PIC tertentu
    public function riwayatOrder(Request $request)
    {
        $request->validate([
            'id_pic' => 'required|exists:users,id_user',
        ]);

        $orders = Order::where('id_PIC', $request->id_pic)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json(['orders' => $orders]);
    }
}
