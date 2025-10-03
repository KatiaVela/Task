<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ticket;
use App\Models\Event;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition()
    {
        return [
            'event_id' => Event::factory(),
            'type' => fake()->randomElement(['VIP', 'Regular', 'Student']),
            'price' => fake()->randomFloat(2, 10, 200),
            'quantity' => fake()->numberBetween(10, 100),
        ];
    }
}
