<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!in_array($request->user()->role, $roles)) {
            return response()->json([
                'message' => 'Unauthorized. You do not have access to this resource.'
            ], 403);
        }

        return $next($request);
    }
}
