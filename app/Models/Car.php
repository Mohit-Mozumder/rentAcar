<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand', 'model', 'engine', 'quantity', 'price_per_day', 'status', 'reduce', 'stars', 'image',
        'driver_name', 'driver_phone', 'driver_nid', 'driver_photo'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function insurance()
    {
        return $this->hasOne(Insurance::class);
    }
}
