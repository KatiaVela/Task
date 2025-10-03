<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Booking;

class DatabaseSeeder extends Seeder
{
   public function run(): void
{
    // Clear existing data
    \App\Models\User::query()->delete();
    \App\Models\Event::query()->delete();
    \App\Models\Ticket::query()->delete();
    \App\Models\Booking::query()->delete();
    
    // Reset auto-increment counters for SQLite
    if (\DB::connection() instanceof \Illuminate\Database\SQLiteConnection) {
        \DB::statement('DELETE FROM sqlite_sequence');
    }

    // 2 Admins
    User::factory()->count(2)->admin()->create();

    // 3 Organizers
    $organizer1 = User::factory()->organizer()->create(['name' => 'Organizer 1']);
    $organizer2 = User::factory()->organizer()->create(['name' => 'Organizer 2']);
    $organizer3 = User::factory()->organizer()->create(['name' => 'Organizer 3']);

    // 10 Customers
    $customers = User::factory()->count(10)->customer()->create();

    // 5 Events (created by organizers)
    $events = collect();
    
    // First organizer creates 3 events
    for ($i = 0; $i < 3; $i++) {
        $event = Event::factory()->make();
        $event->user_id = $organizer1->id;
        $event->save();
        $events->push($event);
    }
    
    // Second organizer creates 2 events
    for ($i = 0; $i < 2; $i++) {
        $event = Event::factory()->make();
        $event->user_id = $organizer2->id;
        $event->save();
        $events->push($event);
    }

    // 15 Tickets (3 tickets per event)
    $tickets = collect();
    foreach ($events as $event) {
        for ($i = 0; $i < 3; $i++) {
            $ticket = Ticket::factory()->make();
            $ticket->event_id = $event->id;
            $ticket->save();
            $tickets->push($ticket);
        }
    }

    // 20 Bookings (customers booking tickets)
    for ($i = 0; $i < 20; $i++) {
        $booking = new Booking();
        $booking->user_id = $customers->random()->id;
        $booking->ticket_id = $tickets->random()->id;
        $booking->quantity = rand(1, 5);
        $booking->status = ['pending', 'confirmed', 'cancelled'][rand(0, 2)];
        $booking->save();
    }
}
}
