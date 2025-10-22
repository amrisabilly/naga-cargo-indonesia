<?php

namespace Database\Seeders;

use App\Models\OrderFoto;
use Illuminate\Database\Seeder;

class OrderFotoSeeder extends Seeder
{
    public function run()
    {
        OrderFoto::factory()->count(50)->create();
    }
}