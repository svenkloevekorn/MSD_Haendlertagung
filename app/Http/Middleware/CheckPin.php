<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPin
{
    public function handle(Request $request, Closure $next): Response
    {
        $dealerId = session('dealer_id');
        $loggedInAt = session('dealer_logged_in_at');

        if (! $dealerId || ! $loggedInAt) {
            return redirect()->route('login');
        }

        // Session nach 72h ablaufen lassen
        if (now()->timestamp - $loggedInAt > 72 * 60 * 60) {
            session()->forget(['dealer_id', 'dealer_logged_in_at']);

            return redirect()->route('login');
        }

        return $next($request);
    }
}
