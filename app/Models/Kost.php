<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    protected $fillable = [
        'user_id', 
        'name', 
        'description', 
        'address', 
        'price_per_month'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campuses()
    {
        return $this->belongsToMany(Campus::class);
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class);
    }

    public function kostImages()
    {
        return $this->hasMany(KostImage::class);
    }

    public function occupancies()
    {
        return $this->hasMany(Occupancy::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
