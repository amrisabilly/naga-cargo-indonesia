<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {
        //Order::factory()->count(1)->create();
        Order::create(
            [
                'AWB' => 'AWB1234567890',
                'id_pic' => 1,
                'id_daerah' => 1,
                'tujuan' => 'Jl. Merdeka No. 1, Sleman',
                'status' => 'Gagal',
            ]
        );
        Order::create(
            [
                'AWB' => 'AWB123',
                'id_pic' => 1,
                'id_daerah' => 2,
                'tujuan' => 'Jl. Merdeka No. 1, bantul',
            ]
        );
        Order::create(
            [
                'AWB' => 'AWB1111',
                'id_pic' => 4,
                'id_daerah' => 2,
                'tujuan' => 'Jl. Merdeka No. 1, Jakarta',
            ]
        );
    }
}
