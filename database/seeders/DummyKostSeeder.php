<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kost;
use App\Models\Campus;
use App\Models\Facility;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DummyKostSeeder extends Seeder
{
    public function run(): void
    {
        // Panggil Faker khusus bahasa/format Indonesia
        $faker = Faker::create('id_ID');

        // Ambil data ID kampus dan fasilitas yang udah ada di database lu
        $campusIds = Campus::pluck('id')->toArray();
        $facilityIds = Facility::pluck('id')->toArray();

        // Daftar daerah/kecamatan di Bandung untuk data dummy yang lebih realistis
        $daerahBandung = ['Sukasari', 'Cicaheum', 'Coblong', 'Dago', 'Ciumbuleuit', 'Buahbatu', 'Dayeuhkolot', 'Cicendo', 'Lengkong', 'Antapani'];

        // Daftar 4 Owner Sesuai Permintaan Lu
        $owners = [
            ['name' => 'Riska Mutiara', 'email' => 'owner1@kostreview.com'],
            ['name' => 'Mimik Tutu', 'email' => 'owner2@kostreview.com'],
            ['name' => 'Earl Jombang', 'email' => 'owner3@kostreview.com'],
            ['name' => 'Hedra Alas Daun', 'email' => 'owner4@kostreview.com'],
        ];

        // Looping 1: Eksekusi pembuatan 4 Akun Owner
        foreach ($owners as $ownerData) {
            
            // Pakai firstOrCreate biar kalau lu run seeder berkali-kali, emailnya ga bentrok/error
            $owner = User::firstOrCreate(
                ['email' => $ownerData['email']], 
                [
                    'name' => $ownerData['name'],
                    'password' => Hash::make('password123'),
                    'role' => 'owner',
                ]
            );

            // Looping 2: Bikin 4 Kosan untuk masing-masing Owner (Total 16 Kosan)
            for ($j = 1; $j <= 4; $j++) {
                
                // Ambil daerah acak di Bandung
                $daerah = $faker->randomElement($daerahBandung);
                
                // Bikin data kosan
                $kost = Kost::create([
                    'user_id' => $owner->id,
                    'name' => 'Kos ' . $faker->firstName() . ' ' . $daerah, // Contoh: Kos Budi Sukasari
                    'price_per_month' => $faker->numberBetween(6, 25) * 100000, // Harga 600rb - 2.5jt
                    'address' => $faker->streetAddress() . ', Kec. ' . $daerah . ', Kota Bandung',
                    'description' => 'Kos eksklusif dan nyaman di daerah ' . $daerah . '. Lingkungan aman, dekat dengan minimarket, dan akses transportasi 24 jam. ' . $faker->paragraph(1),
                ]);

                // Tempelin 1-2 Kampus terdekat secara acak ke kosan ini
                if (!empty($campusIds)) {
                    $randomCampuses = $faker->randomElements($campusIds, rand(1, 2));
                    $kost->campuses()->attach($randomCampuses);
                }
                
                // Tempelin 2-4 Fasilitas secara acak ke kosan ini
                if (!empty($facilityIds)) {
                    $randomFacilities = $faker->randomElements($facilityIds, rand(2, 4));
                    $kost->facilities()->attach($randomFacilities);
                }
            }
        }
    }
}