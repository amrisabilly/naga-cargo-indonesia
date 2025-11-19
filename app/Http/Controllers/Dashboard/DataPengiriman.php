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
        // Urutkan berdasarkan perubahan terbaru
        $pengiriman = Order::with('user')
            ->where('id_daerah', $id_daerah)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('dashboard.data.detail', compact('daerah', 'pengiriman'));
    }

    // show detail pengiriman
    public function show(string $AWB)
    {
        $order = Order::with(['user'])->where('AWB', $AWB)->firstOrFail();
        $fotos = OrderFoto::where('AWB', $AWB)->get();
        foreach ($fotos as $foto) {
            $foto->url = asset('storage/' . $foto->path_foto);
        }
        return view('dashboard.data.show', compact('order', 'fotos'));
    }
}
