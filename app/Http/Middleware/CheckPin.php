<?php

namespace App\Http\Middleware;

use App\Models\Dealer;
use App\Models\FormSubmission;
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

        // Internal dealers have no form obligations
        if ($dealer->is_internal) {
            View::share('hasFeedback', true);
            View::share('todoItems', []);

            return $next($request);
        }

        $saved = FormSubmission::where('form_slug', FormSubmission::FORM_REGISTRATION)
            ->where('dealer_id', $dealerId)
            ->first()?->data ?? [];

        $marketSaved = FormSubmission::where('form_slug', FormSubmission::FORM_MARKET_INFO)
            ->where('dealer_id', $dealerId)
            ->first()?->data ?? [];

        $hasFeedback = FormSubmission::where('form_slug', FormSubmission::FORM_FEEDBACK)
            ->where('dealer_id', $dealerId)
            ->exists();
        View::share('hasFeedback', $hasFeedback);

        $todoItems = [];
        $hasMarketInfo = ! empty($marketSaved['delegated_to'] ?? null)
            || (! empty($marketSaved['market_share'] ?? null)
            && ! empty($marketSaved['challenges'] ?? null)
            && ! empty($marketSaved['chances_potential'] ?? null)
            && ! empty($marketSaved['competitors'] ?? null)
            && ! empty($marketSaved['expectations'] ?? null));
        if (! $hasMarketInfo) {
            $todoItems[] = ['label' => 'Market Info', 'deadline' => 'May 15, 2026', 'route' => 'market-info'];
        }
        if (! $hasFeedback) {
            $todoItems[] = ['label' => 'Feedback', 'route' => 'feedback'];
        }
        if (empty($saved['factory_tour'] ?? null)) {
            $todoItems[] = ['label' => 'Factory Tour', 'deadline' => 'May 1, 2026'];
        }
        if (($saved['no_companion'] ?? '') !== 'true'
            && (empty($saved['activity_1'] ?? null) || empty($saved['activity_2'] ?? null) || empty($saved['activity_3'] ?? null))) {
            $todoItems[] = ['label' => 'Activities Ranking', 'deadline' => 'May 1, 2026'];
        }
        if (empty($saved['allergies'] ?? null) && ($saved['no_allergies'] ?? '') !== 'true') {
            $todoItems[] = ['label' => 'Intolerances / Allergies', 'deadline' => 'June 1, 2026'];
        }
        $hasCompanionHandled = ($saved['no_companion'] ?? '') === 'true' || ! empty($saved['companion_mobile'] ?? null);
        if (empty($saved['mobile'] ?? null) || ! $hasCompanionHandled) {
            $todoItems[] = ['label' => 'Mobile Numbers', 'deadline' => 'June 10, 2026'];
        }
        View::share('todoItems', $todoItems);

        return $next($request);
    }
}
