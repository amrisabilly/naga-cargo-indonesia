<?php

namespace Database\Seeders;

use App\Models\Daerah;
use Illuminate\Database\Seeder;

class DaerahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Daerah::factory()->count(3)->create();
        Daerah::create([
            'kode_daerah' => 'JKT',
            'nama' => 'Jakarta',
        ]);
        Daerah::create([
            'kode_daerah' => 'BDG',
            'nama' => 'Bandung',
        ]);
        Daerah::create([
            'kode_daerah' => 'SBY',
            'nama' => 'Surabaya',
        ]);
    }
}