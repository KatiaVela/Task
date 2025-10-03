<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Event;
use App\Models\User;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'location' => fake()->city(),
            'date' => fake()->dateTimeBetween('+1 week', '+6 months'),
            'capacity' => fake()->numberBetween(50, 500),
            'user_id' => User::factory()->organizer(), // organizer creates it
        ];
    }
}
