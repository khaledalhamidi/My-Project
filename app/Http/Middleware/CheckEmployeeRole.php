<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckEmployeeRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'You are not logged in.'], 401);
        }

        if (Auth::user()->role !== 'manager') {
            return response()->json(['message' => 'Sorry, you are not authorized.'], 403);
        }

        // User is a manager, continue to the controller
        return $next($request);
    }
}
