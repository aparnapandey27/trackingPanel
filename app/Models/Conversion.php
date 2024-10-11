<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    use HasFactory;

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }
    public function advertiser()
    {
        return $this->belongsTo(User::class, 'advertiser_id', 'id');
    }
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
