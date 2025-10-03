<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'amount',
        'method',     // e.g. credit_card, paypal, bank_transfer
        'status',     // e.g. pending, completed, failed
        'transaction_id',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
