<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->hasRole('admin')) {
            $bookings = Booking::with(['user', 'ticket.event'])->get();
        } else {
            $bookings = $user->bookings()->with(['ticket.event'])->get();
        }
        
        return response()->json($bookings);
    }

    public function store(Request $request, $ticketId)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
    
        return DB::transaction(function () use ($ticketId, $validated) {
            $ticket = Ticket::findOrFail($ticketId);
            
            if ($ticket->quantity_available < $validated['quantity']) {
                return response()->json([
                    'message' => 'Not enough tickets available',
                ], 400);
            }
    
            $booking = Auth::user()->bookings()->create([
                'ticket_id' => $ticket->id,
                'event_id' => $ticket->event_id, // Add this line
                'quantity' => $validated['quantity'],
                'total_price' => $ticket->price * $validated['quantity'],
                'status' => 'confirmed',
            ]);
    
            $ticket->decrement('quantity_available', $validated['quantity']);
    
            return response()->json($booking, 201);
        });
    }

    public function cancel($id)
    {
        $booking = Booking::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if ($booking->status === 'cancelled') {
            return response()->json([
                'message' => 'Booking is already cancelled',
            ], 400);
        }

        DB::transaction(function () use ($booking) {
            $booking->ticket->increment('quantity_available', $booking->quantity);
            $booking->update(['status' => 'cancelled']);
        });

        return response()->json([
            'message' => 'Booking cancelled successfully',
        ]);
    }
}
