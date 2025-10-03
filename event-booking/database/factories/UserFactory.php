<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // default password
            'remember_token' => Str::random(10),
            'role' => 'customer', // default
        ];
    }

    public function admin()
    {
        return $this->state(fn () => ['role' => 'admin']);
    }

    public function organizer()
    {
        return $this->state(fn () => ['role' => 'organizer']);
    }

    public function customer()
    {
        return $this->state(fn () => ['role' => 'customer']);
    }
}
