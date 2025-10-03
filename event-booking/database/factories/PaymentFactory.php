<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Payment;
use App\Models\Booking;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'booking_id' => Booking::factory(),
            'amount' => fake()->randomFloat(2, 20, 500),
            'method' => fake()->randomElement(['credit_card', 'paypal', 'bank_transfer']),
            'status' => fake()->randomElement(['pending', 'completed', 'failed']),
            'transaction_id' => strtoupper(fake()->bothify('TXN#######')),
        ];
    }
}
