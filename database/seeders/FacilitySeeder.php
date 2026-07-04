<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar fasilitas yang mau diinput otomatis
        $facilities = [
            ['name' => 'WiFi Gratis'],
            ['name' => 'AC'],
            ['name' => 'Kamar Mandi Dalam'],
            ['name' => 'Kasur & Lemari'],
            ['name' => 'Parkir Motor'],
        ];

        // Looping untuk memasukkan data ke database jika belum ada
        foreach ($facilities as $facility) {
            Facility::firstOrCreate($facility);
        }
    }
}