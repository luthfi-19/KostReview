<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    protected $fillable = ['name', 'address'];
    
    public function kosts()
    {
        return $this->belongsToMany(Kost::class);
    }
}
