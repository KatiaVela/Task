<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        // Start building the query
        $query = Event::with('user');
    
        // Apply search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }
    
        // Apply date filter
        if ($request->has('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }
    
        // Apply location filter
        if ($request->has('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }
    
        // Only show public events to non-authenticated users
        if (!$request->user()) {
            $query->where('is_public', true);
        } else {
            // For authenticated users who are not admins, show their own events + public ones
            if ($request->user()->role !== 'admin') {
                $query->where(function($q) use ($request) {
                    $q->where('is_public', true)
                      ->orWhere('user_id', $request->user()->id);
                });
            }
        }
    
        // Apply pagination
        $perPage = $request->per_page ?? 15;
        $events = $query->latest()->paginate($perPage);
    
        return response()->json([
            'data' => $events->items(),
            'pagination' => [
                'total' => $events->total(),
                'per_page' => $events->perPage(),
                'current_page' => $events->currentPage(),
                'last_page' => $events->lastPage(),
                'from' => $events->firstItem(),
                'to' => $events->lastItem(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        // Add the authenticated user's ID to the event data
        $validated['user_id'] = $request->user()->id;

        $event = Event::create($validated);
        return response()->json($event, 201);
    }

    public function show(Event $event)
    {
        return response()->json($event);
    }

    public function update(Request $request, Event $event)
    {
        // Check if the authenticated user is the owner of the event
        if ($request->user()->id !== $event->user_id) {
            return response()->json([
                'message' => 'You are not authorized to update this event.'
            ], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'date' => 'sometimes|date',
            'location' => 'sometimes|string|max:255',
            'capacity' => 'sometimes|integer|min:1',
        ]);

        $event->update($validated);
        return response()->json($event);
    }

    public function destroy(Request $request, Event $event)
    {
        // Check if the authenticated user is the owner of the event
        if ($request->user()->id !== $event->user_id) {
            return response()->json([
                'message' => 'You are not authorized to delete this event.'
            ], 403);
        }

        $event->delete();
        return response()->json(null, 204);
    }
}
