<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentDummySeeder extends Seeder
{
    public function run(): void
    {
        // Daftar akun dummy Student buat testing/demo
        $students = [
            ['email' => 'user1@kostreview.com', 'name' => 'Kakangku'],
            ['email' => 'user2@kostreview.com', 'name' => 'Ryan GreenFlag'],
            ['email' => 'user3@kostreview.com', 'name' => 'Aimar Nur Rohim'],
            ['email' => 'user4@kostreview.com', 'name' => 'Mursyid Mursalin'],
            ['email' => 'user5@kostreview.com', 'name' => 'Aynid Morbulet'],
        ];

        foreach ($students as $student) {
            User::updateOrCreate(
                ['email' => $student['email']], // Patokannya email ini
                [
                    'name' => $student['name'],
                    'password' => Hash::make('pass123'),
                    'role' => 'student',
                ]
            );
        }
    }
}