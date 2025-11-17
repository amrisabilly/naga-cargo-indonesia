<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Daerah;
use App\Models\Order;
use App\Models\OrderFoto;
use Illuminate\Http\Request;

class DataPengiriman extends Controller
{

    public function showByDaerah($id_daerah)
    {
        // Ambil data daerah
        $daerah = Daerah::where('id_daerah', $id_daerah)->firstOrFail();

        // Eager load relasi user (kurir)
        $pengiriman = Order::with('user')->where('id_daerah', $id_daerah)->get();

        return view('dashboard.data.detail', compact('daerah', 'pengiriman'));
    }

    // show detail pengiriman
    public function show(string $AWB)
    {
        $order = Order::with('user')->where('AWB', $AWB)->firstOrFail();

        // Ambil fotos dan tambahkan full URL
        $fotos = OrderFoto::where('AWB', $AWB)->get()->map(function ($foto) {
            return [
                'id_foto' => $foto->id_foto,
                'AWB' => $foto->AWB,
                'path_foto' => $foto->path_foto,
                'url' => asset('storage/' . $foto->path_foto), // Full URL
                'keterangan' => $foto->keterangan,
                'created_at' => $foto->created_at,
                'updated_at' => $foto->updated_at,
            ];
        });

        return view('dashboard.data.show', compact('order', 'fotos'));
    }
}
