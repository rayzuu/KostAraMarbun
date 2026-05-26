<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'kapasitas',
        'status'
    ];
    public function images()
    {
        return $this->hasMany(RoomImage::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
