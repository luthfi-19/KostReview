<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occupancy extends Model
{
    use HasFactory;

    // Kolom yang diizinkan untuk diisi
    protected $fillable = [
        'user_id',
        'kost_id',
        'status',
        'start_date', // Tambahkan izin untuk start_date
        'end_date',   // Tambahkan izin untuk end_date (jaga-jaga kalau ditagih juga)
    ];

    // Relasi: Satu riwayat hunian ini milik satu Mahasiswa (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Satu riwayat hunian ini terhubung ke satu Kos
    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }
}