<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

public function test_user_can_register()
{
    $response = $this->postJson('/api/register', [  
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'customer'
    ]);

    $response->assertStatus(201)
             ->assertJsonStructure(['user', 'token']);
             
    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
        'name' => 'Test User',
        'role' => 'customer'
    ]);
}

public function test_user_can_login()
{
    // Create a user first
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
        'role' => 'customer'
    ]);

    $response = $this->postJson('/api/login', [ 
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(200)
             ->assertJsonStructure(['token']);
}
}
