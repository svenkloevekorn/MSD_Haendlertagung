<?php

namespace App\Http\Middleware;

use App\Models\Dealer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
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

        $dealer = Dealer::find($dealerId);
        View::share('dealer', $dealer);

        return $next($request);
    }
}
