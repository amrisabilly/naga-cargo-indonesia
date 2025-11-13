<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Daerah;
use App\Models\Order;
use App\Models\OrderFoto;
use Illuminate\Http\Request;

class DataPengiriman extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.data.index');
    }

    public function daerah()
    {
        // Menampilkan halaman data daerah pengiriman
        $daerah = Daerah::select('id_daerah', 'nama')->get();
        return view('dashboard.data.daerah', compact('daerah'));
    }

    public function showByDaerah($id_daerah)
    {
        // Ambil data daerah
        $daerah = Daerah::where('id_daerah', $id_daerah)->firstOrFail();

        // Eager load relasi user (kurir)
        $pengiriman = Order::with('user')->where('id_daerah', $id_daerah)->get();

        return view('dashboard.data.index', compact('daerah', 'pengiriman'));
    }

    // show detail pengiriman
    public function show(string $AWB)
    {
        $order = Order::with('user')->where('AWB', $AWB)->firstOrFail();
        $fotos = OrderFoto::where('AWB', $AWB)->get();
        return view('dashboard.data.show', compact('order', 'fotos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
