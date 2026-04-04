<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\FormSubmission;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MarketInfoController extends Controller
{
    public function show(): View
    {
        $dealer = Dealer::find(session('dealer_id'));
        $submission = FormSubmission::where('form_slug', FormSubmission::FORM_MARKET_INFO)
            ->where('dealer_id', $dealer->id)
            ->first();

        $saved = $submission?->data ?? [];

        return view('market-info', compact('saved'));
    }

    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'market_share' => 'nullable|string|max:5000',
            'challenges' => 'nullable|string|max:5000',
            'chances_potential' => 'nullable|string|max:5000',
            'competitors' => 'nullable|string|max:5000',
            'expectations' => 'nullable|string|max:5000',
        ]);

        $dealer = Dealer::find(session('dealer_id'));

        FormSubmission::updateOrCreate(
            [
                'form_slug' => FormSubmission::FORM_MARKET_INFO,
                'dealer_id' => $dealer->id,
            ],
            ['data' => [
                'first_name' => $dealer->first_name,
                'last_name' => $dealer->last_name,
                'market_share' => $validated['market_share'] ?? '',
                'challenges' => $validated['challenges'] ?? '',
                'chances_potential' => $validated['chances_potential'] ?? '',
                'competitors' => $validated['competitors'] ?? '',
                'expectations' => $validated['expectations'] ?? '',
            ]]
        );

        $confirmation = Setting::get(
            'confirmation_market_info',
            'Your market information has been saved!'
        );

        return redirect()->route('market-info')->with('success', $confirmation);
    }
}
