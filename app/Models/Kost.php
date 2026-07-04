<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'price_per_month',
        'address',
        'description',
    ];

    // 1. Relasi ke Owner (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 2. Relasi ke Foto Kos
    public function images()
    {
        return $this->hasMany(KostImage::class);
    }

    // 3. Relasi ke Pengajuan Sewa
    public function occupancies()
    {
        return $this->hasMany(Occupancy::class);
    }

    // 4. Relasi ke Ulasan
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // 5. Relasi ke Fasilitas (Hanya ada SATU di sini)
    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'kost_facility');
    }

    // Relasi: Satu Kos bisa dekat dengan banyak Kampus
    public function campuses()
    {
        return $this->belongsToMany(Campus::class, 'kost_campus');
    }
}