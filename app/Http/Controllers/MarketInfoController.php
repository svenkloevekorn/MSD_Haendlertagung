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
        $dealer = Dealer::find(session('dealer_id'));
        $delegatedTo = $request->input('delegated_to', '');
        $isDelegated = $request->has('delegated') && ! empty($delegatedTo);

        $saveData = [
            'first_name' => $dealer->first_name,
            'last_name' => $dealer->last_name,
            'delegated_to' => $delegatedTo,
            'market_share' => $request->input('market_share', ''),
            'challenges' => $request->input('challenges', ''),
            'chances_potential' => $request->input('chances_potential', ''),
            'competitors' => $request->input('competitors', ''),
            'expectations' => $request->input('expectations', ''),
        ];

        FormSubmission::updateOrCreate(
            [
                'form_slug' => FormSubmission::FORM_MARKET_INFO,
                'dealer_id' => $dealer->id,
            ],
            ['data' => $saveData]
        );

        // If delegated, only check colleague name
        if ($request->has('delegated')) {
            if (empty($delegatedTo)) {
                return redirect()->route('market-info')
                    ->withErrors(['delegated_to' => 'Please enter the name of your colleague.'])
                    ->withInput();
            }

            $confirmation = Setting::get('confirmation_market_info', 'Your market information has been saved!');
            return redirect()->route('market-info')->with('success', $confirmation);
        }

        // Check for missing fields
        $missing = [];
        $messages = [
            'market_share' => 'Please fill in the MS Market Share field.',
            'challenges' => 'Please fill in the Challenges field.',
            'chances_potential' => 'Please fill in the Chances / Potential field.',
            'competitors' => 'Please fill in the Competitors field.',
            'expectations' => 'Please fill in the Expectations field.',
        ];
        foreach ($messages as $field => $msg) {
            if (empty($saveData[$field])) {
                $missing[$field] = $msg;
            }
        }

        $confirmation = Setting::get('confirmation_market_info', 'Your market information has been saved!');

        if (! empty($missing)) {
            return redirect()->route('market-info')
                ->withErrors($missing)
                ->withInput();
        }

        return redirect()->route('market-info')->with('success', $confirmation);
    }
}
