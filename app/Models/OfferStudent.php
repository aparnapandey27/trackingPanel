<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferStudent extends Model
{
    use HasFactory;
    
     /*
    * Get the goal's parent offer
    */
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class,'student_id','id');
    }
}
