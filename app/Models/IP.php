<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IP extends Model
{
    use HasFactory;
    public function advertiser()
    {
        return $this->belongsTo(User::class, 'advertiser_id');
    }
}
