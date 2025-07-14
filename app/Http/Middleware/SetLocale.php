<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
            $locale = $request->header('lang', $request->query('lang'));

    if ($locale && in_array($locale, ['ar', 'en'])) {
        App::setLocale($locale);
    } else {
        App::setLocale(config('app.locale')); // fallback
    }
    return $next($request);
}
}
