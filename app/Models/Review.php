<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kost_id',
        'rating',
        'comment',
    ];

    // Relasi: Review ini ditulis oleh satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Review ini ditujukan untuk satu Kos
    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }
}