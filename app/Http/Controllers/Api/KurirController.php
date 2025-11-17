<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Daerah;
use App\Models\Order;
use App\Models\OrderFoto;
use App\Models\User;
use Illuminate\Http\Request;

class KurirController extends Controller
{
    /**
     * Login Kurir
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $kurir = User::where('username', $request->username)
            ->where('role', 'Kurir')
            ->first();

        if (!$kurir || $kurir->password !== $request->password) {
            return response()->json(['message' => 'Login gagal'], 401);
        }

        // Ambil nama daerah dari relasi
        $nama_daerah = null;
        if ($kurir->id_daerah) {
            $daerah = Daerah::find($kurir->id_daerah);
            $nama_daerah = $daerah ? $daerah->nama : "Daerah Tidak Ditemukan";
        }

        return response()->json([
            'message' => 'Login berhasil',
            'user' => $kurir,
            'nama_daerah' => $nama_daerah
        ]);
    }

    /**
     * Update Order oleh Kurir
     * Kurir melengkapi data order yang dibuat PIC
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'AWB' => 'required|string',
            'id_kurir' => 'required',
            'tanggal' => 'required',
            'penerima' => 'required',
            'no_hp' => 'required|string|max:20',
        ]);

        // Cek kurir
        $kurir = User::where('id_user', $request->id_kurir)
            ->where('role', 'Kurir')
            ->first();

        if (!$kurir) {
            return response()->json(['message' => 'Kurir tidak ditemukan'], 404);
        }

        // Cek order
        $order = Order::where('AWB', $request->AWB)->first();
        if (!$order) {
            return response()->json(['message' => 'Order tidak ditemukan'], 404);
        }

        // Update order dengan data kurir
        $order->update([
            'id_user' => $kurir->id_user,
            'tanggal' => $request->tanggal,
            'penerima' => $request->penerima,
            'no_hp' => $request->no_hp,
            'status' => 'Terkirim',
        ]);

        return response()->json([
            'message' => 'Order berhasil diupdate',
            'order' => $order
        ]);
    }

    /**
     * Upload Foto Order oleh Kurir
     */
    public function uploadFoto(Request $request)
    {
        $request->validate([
            'AWB' => 'required|string',
            'fotos' => 'required',
            'fotos.*' => 'image',
            'keterangan' => 'nullable',
            'keterangan.*' => 'nullable|string',
        ]);

        // Cek order
        $order = Order::where('AWB', $request->AWB)->first();
        if (!$order) {
            return response()->json(['message' => 'Order tidak ditemukan'], 404);
        }

        $uploadedFotos = [];

        // Upload setiap foto
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $index => $file) {
                // Nama file dengan format: AWB_nomor_timestamp.ext
                $filename = $request->AWB . '_' . ($index + 1) . '_' . time() . '.' . $file->getClientOriginalExtension();

                // Store ke folder public/storage/order-fotos
                $path = $file->storeAs('', $filename, 'public');

                // Simpan data foto ke database
                $foto = OrderFoto::create([
                    'AWB' => $request->AWB,
                    'path_foto' => $path, // Hanya simpan: order-fotos/test123_1_1700000000.jpg
                    'keterangan' => $request->keterangan[$index] ?? null,
                ]);

                $uploadedFotos[] = $foto;
            }
        }

        return response()->json([
            'message' => 'Foto berhasil diupload',
            'total_fotos' => count($uploadedFotos),
            'fotos' => $uploadedFotos
        ]);
    }

    /**
     * Riwayat Order untuk Kurir
     */
    public function riwayatOrder(Request $request)
    {
        $request->validate([
            'id_kurir' => 'required|exists:users,id_user',
        ]);

        $orders = Order::where('id_user', $request->id_kurir)
            ->with('daerah', 'orderFoto') // Hapus 'pic'
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'orders' => $orders
        ]);
    }

    /**
     * Detail Order untuk Kurir
     */
    public function detailOrder(Request $request, $AWB)
    {
        $order = Order::where('AWB', $AWB)
            ->with('daerah', 'orderFoto') // Hapus 'pic'
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Order tidak ditemukan'], 404);
        }

        return response()->json([
            'order' => $order
        ]);
    }

    /**
     * Ambil Daftar Order Sesuai Daerah Kurir
     * (Untuk dropdown rekomendasi pencarian)
     */
    public function getOrderByDaerah(Request $request)
    {
        $request->validate([
            'id_kurir' => 'required|exists:users,id_user',
        ]);

        // Ambil kurir
        $kurir = User::where('id_user', $request->id_kurir)
            ->where('role', 'Kurir')
            ->first();

        if (!$kurir) {
            return response()->json(['message' => 'Kurir tidak ditemukan'], 404);
        }

        // Ambil order sesuai daerah kurir yang statusnya 'Proses' (belum diproses kurir)
        $orders = Order::where('id_daerah', $kurir->id_daerah)
            ->where('status', 'Proses')
            ->where('id_user', null) // Belum ada kurir yang ambil
            ->select('AWB', 'tujuan', 'penerima', 'status')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'message' => 'Data order berdasarkan daerah',
            'daerah' => $kurir->daerah->nama ?? 'Tidak ada daerah',
            'total_order' => count($orders),
            'orders' => $orders
        ]);
    }

    /**
     * Cari Order berdasarkan AWB (dari dropdown list)
     */
    public function searchOrder(Request $request)
    {
        $request->validate([
            'AWB' => 'required|string',
            'id_kurir' => 'required|exists:users,id_user',
        ]);

        // Ambil kurir
        $kurir = User::where('id_user', $request->id_kurir)
            ->where('role', 'Kurir')
            ->first();

        if (!$kurir) {
            return response()->json(['message' => 'Kurir tidak ditemukan'], 404);
        }

        // Cari order sesuai AWB dan harus dalam daerah yang sama
        $order = Order::where('AWB', $request->AWB)
            ->where('id_daerah', $kurir->id_daerah)
            ->with('daerah')
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Order tidak ditemukan di daerah Anda'], 404);
        }

        // Jika sudah terkirim, tolak
        if ($order->status === 'Terkirim') {
            return response()->json(['message' => 'Order sudah terkirim'], 422);
        }

        return response()->json([
            'message' => 'Order ditemukan',
            'order' => $order
        ]);
    }
}
