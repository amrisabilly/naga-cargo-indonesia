<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {

        Admin::create([
            'username' => 'bima',
            'password' => '123',
            'nama' => 'Bima',
        ]);

        Admin::create([
            'username' => 'billy',
            'password' => '123',
            'nama' => 'Billy',
        ]);
    }
}