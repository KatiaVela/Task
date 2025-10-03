<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\CommonQueryScopes;

class Event extends Model
{
    use HasFactory, CommonQueryScopes;

    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'user_id'
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
