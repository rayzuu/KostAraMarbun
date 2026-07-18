<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [

    'booking_id',

    'midtrans_order_id',

    'payment_month',

    'payment_year',

    'amount',

    'status',

    'paid_at',

    'transaction_status',

    'duration',
    
    'payment_type',

    'bank',

    'va_number',

    'transaction_time'

];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}