<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventDoubleBooking
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $ticketId = $request->route('id') ?? $request->route('ticket');
        // If booking endpoint uses ticket id param name other than id adjust accordingly
        $existing = \App\Models\Booking::where('user_id',$user->id)
                     ->where('ticket_id',$ticketId)
                     ->whereIn('status',['pending','confirmed'])
                     ->first();
        if($existing){
            return response()->json(['message'=>'You already have a booking for this ticket.'], 409);
        }
        return $next($request);
    }
}
