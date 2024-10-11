<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferGoal extends Model
{
    use HasFactory;


    protected $fillable = [
        'offer_id',
        'goal_id',
        'pay_model',
        'currency',
        'default_revenue',
        'percent_revenue',
        'default_payout',
        'percent_payout',
    ];
    
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
    public function goalName()
    {
        return $this->belongsTo(GoalName::class, 'goal_id');
    }
}
