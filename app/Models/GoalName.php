<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoalName extends Model
{
    use HasFactory;
    protected $table = 'goal_names';

    protected $fillable = ['name'];
    
    public function goals()
    {
        return $this->hasMany(OfferGoal::class, 'goal_id');
    }
}
