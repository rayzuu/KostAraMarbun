<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [

        'room_id',
        'name',
        'phone',
        'birth_place',
        'birth_date',
        'start_date',
        'monthly_price',
        'status'

    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}