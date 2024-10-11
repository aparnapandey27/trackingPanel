<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferSharePayout extends Model
{
    use HasFactory;
    protected $fillable = [
        'offer_id','student_id'
    ];
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }
    
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
