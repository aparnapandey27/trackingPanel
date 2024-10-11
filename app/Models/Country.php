<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public function offers()
    {
        return $this->belongsToMany(Offer::class);
    }

    public function states()
    {
        return $this->hasMany(State::class);
    }
}
