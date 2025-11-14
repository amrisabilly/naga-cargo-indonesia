<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        //User::factory()->count(200)->create();
        User::create([
            'username' => 'billy',
            'password' => '123',
            'role' => 'PIC',
            'nama' => 'User One',
        ]);
        User::create([
            'username' => 'bima',
            'password' => '123',
            'role' => 'Kurir',
            'nama' => 'User Two',
        ]);
        User::create([
            'username' => 'danu',
            'password' => '123',
            'role' => 'Kurir',
            'nama' => 'User Three',
        ]);
        User::create([
            'username' => 'coklat',
            'password' => '123',
            'role' => 'PIC',
            'nama' => 'User four',
        ]);
    }
}