<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;

class DataController extends Controller
{

    public function index()
    {
        $totalPengiriman = Order::count();
        $totalKurir = User::where('role', 'kurir')->count();
        $totalPIC = User::where('role', 'PIC')->count();

        $statistikPengiriman = Order::selectRaw('YEAR(tanggal) as tahun, MONTH(tanggal) as bulan, COUNT(*) as total')
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        $dataStatistik = [];
        $bulanNama = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        foreach ($statistikPengiriman as $statistik) {
            $tahun = $statistik->tahun;
            $bulan = $bulanNama[$statistik->bulan];

            if (!isset($dataStatistik[$tahun])) {
                $dataStatistik[$tahun] = [];
            }

            $dataStatistik[$tahun][$bulan] = [
                'Pengiriman' => $statistik->total,
                'Produk' => rand(10, 50) // Dummy data untuk produk
            ];
        }

        // Pastikan semua bulan ada untuk setiap tahun
        foreach ($dataStatistik as $tahun => &$bulanData) {
            foreach ($bulanNama as $index => $namaBulan) {
                if (!isset($bulanData[$namaBulan])) {
                    $bulanData[$namaBulan] = [
                        'Pengiriman' => 0,
                        'Produk' => 0
                    ];
                }
            }
        }

        return view('dashboard.index', [
            'totalPengiriman' => $totalPengiriman,
            'totalKurir' => $totalKurir,
            'totalPIC' => $totalPIC,
            'statistikPengiriman' => $dataStatistik,
        ]);
    }

    public function data() {
        return view('dashboard.data.index');
    }
}
