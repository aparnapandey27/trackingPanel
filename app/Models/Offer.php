<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'status',
        'created_at',
        'updated_at',
    ];

    /*
    * Get the active offers only
    */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /*
    * Get the offer's advertiser
    */
    public function advertiser()
    {
        return $this->belongsTo(User::class, 'advertiser_id');
    }

    /*
    * Get the offer's category
    */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /*
    * Get the offer's country
    */
    public function countries()
    {
        return $this->belongsToMany(Country::class);
    }

    /*
    * Get the offer's State
    */
    public function states()
    {
        return $this->belongsToMany(State::class);
    }


    /*
    * Get the offer's Devices
    */
    public function devices()
    {
        return $this->belongsToMany(Device::class);
    }


    /*
    * Get the offer's Browsers
    */
    public function browsers()
    {
        return $this->belongsToMany(Browser::class);
    }

    /*
    * Get the offer's redirect parent
    */
    public function redirectOfferParent()
    {
        return $this->belongsTo(self::class, 'redirect_offer_id', 'id');
    }


    /*
    * Get the offer's redirect children
    */
    public function redirectOffers()
    {
        return $this->hasMany(self::class, 'redirect_offer_id', 'id');
    }

    /*
    * Get the offer's request
    */
    public function OfferRequest()
    {
        return $this->hasMany(OfferRequest::class);
    }

    /*
    * Get the offer's Goal/Event
    */
    public function goals()
    {
        return $this->hasMany(OfferGoal::class);
    }

    /*
    * Get the offer's conversions
    */
    public function conversions()
    {
        return $this->hasMany(Conversion::class);
    }
    /*
    * Get the offer's Student
    */
    public function offerStudents()
    {
        return $this->hasMany(OfferStudent::class);
    }
    
    public function clickLimit()
    {
        return $this->hasMany(ClickLimit::class);
    }
    public function conversionLimit()
    {
        return $this->hasMany(ConversionLimit::class);
    }
}
