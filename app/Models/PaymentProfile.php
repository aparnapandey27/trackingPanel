<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'default_payment', 'paypal_email', 'payoneer_email', 'skrill_email', 'webmoney_wmz', 'wise_email'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    public function payment_option()
    {
        return $this->belongsTo(PaymentOption::class, 'payment_method_id', 'id');
    }
}
