<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_events()
    {
        $response = $this->getJson('/api/events');
        $response->assertStatus(200);
    }

    public function test_organizer_can_create_event()
    {
        $organizer = User::factory()->create(['role' => 'organizer']);
        Sanctum::actingAs($organizer);

        $eventData = [
            'title' => 'Test Event',
            'description' => 'Test Description',
            'date' => now()->addWeek()->toDateString(),
            'location' => 'Test Location',
            'capacity' => 100
        ];

        $response = $this->postJson('/api/events', $eventData);
        $response->assertStatus(201)
                ->assertJsonFragment(['title' => 'Test Event']);
    }
}