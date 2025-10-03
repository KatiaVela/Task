<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_book_ticket()
    {
        // Create a user and authenticate
        $user = User::factory()->create(['role' => 'customer']);
        Sanctum::actingAs($user);
    
        // Create an event and ticket
        $event = Event::factory()->create();
        $ticket = Ticket::factory()->create([
            'event_id' => $event->id,
            'quantity_available' => 10,
            'price' => 100
        ]);
    
        // Make a booking
        $response = $this->postJson("/api/tickets/{$ticket->id}/bookings", [
            'quantity' => 1,
            'event_id' => $event->id  // Add this line
        ]);
    
        $response->assertStatus(201)
                ->assertJsonStructure(['id', 'user_id', 'ticket_id', 'event_id', 'status']);
    }
}