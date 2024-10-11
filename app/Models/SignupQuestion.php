<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignupQuestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'is_required',
        'for',
    ];

    public function scopeAdvertiser($query)
    {
        return $query->where('for', 'advertiser');
    }

    public function scopeStudent($query)
    {
        return $query->where('for', 'student');
    }
}
