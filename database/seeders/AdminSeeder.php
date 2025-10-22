<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::factory()->count(5)->create();

        Admin::create([
            'username' => 'bima',
            'password' => bcrypt('123'),
            'nama' => 'Bima',
        ]);

        Admin::create([
            'username' => 'billy',
            'password' => bcrypt('123'),
            'nama' => 'Billy',
        ]);
    }
}