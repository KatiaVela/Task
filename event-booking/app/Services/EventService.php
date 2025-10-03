<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EventService
{
    public function getEvents(Request $request)
    {
        $cacheKey = 'events:' . md5($request->fullUrl());

        return Cache::remember($cacheKey, 60, function () use ($request) {
            $query = Event::query();

            if ($request->search) {
                $query->searchByTitle($request->search);
            }

            if ($request->date) {
                $query->filterByDate($request->date);
            }

            if ($request->location) {
                $query->where('location', 'like', '%' . $request->location . '%');
            }

            return $query->with('tickets')->paginate(15);
        });
    }
}
