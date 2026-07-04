<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Bikin akun khusus Admin secara otomatis
        User::updateOrCreate(
            ['email' => 'admin@kostreview.com'], // Patokannya email ini
            [
                'name' => 'Super Admin',
                'password' => Hash::make('bbb_123123'), // Passwordnya: bbb_123123
                'role' => 'admin',
            ]
        );
    }
}