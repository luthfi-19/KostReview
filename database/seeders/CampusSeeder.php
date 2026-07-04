<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Campus;

class CampusSeeder extends Seeder
{
    public function run(): void
    {
        // Daftar kampus untuk aplikasi lu
        $campuses = [
            ['name' => 'STMIK Mardira Indonesia'],
            ['name' => 'Institut Teknologi Bandung (ITB)'],
            ['name' => 'Universitas Padjadjaran (UNPAD)'],
            ['name' => 'Universitas Pendidikan Indonesia (UPI)'],
            ['name' => 'Telkom University'],
        ];

        foreach ($campuses as $campus) {
            Campus::firstOrCreate($campus);
        }
    }
}