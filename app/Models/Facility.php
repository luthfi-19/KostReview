<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = ['name'];
    
    public function kosts()
    {
        return $this->belongsToMany(Kost::class);
    }
}
