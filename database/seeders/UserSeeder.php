<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('111222'),
        ]);

        User::create([
            'name' => 'Dosen',
            'email' => 'dosen@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Mahasiswa',
            'email' => 'mhs@gmail.com',
            'password' => Hash::make('123456'),
        ]);
    }
}