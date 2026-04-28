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
        $enabled = Setting::get('market_info_enabled', '1') === '1';

        return view('market-info', compact('saved', 'enabled'));
    }

    public function submit(Request $request): RedirectResponse
    {
        if (Setting::get('market_info_enabled', '1') !== '1') {
            return redirect()->route('market-info');
        }

        $dealer = Dealer::find(session('dealer_id'));
        $delegatedTo = $request->input('delegated_to', '');
        $isDelegated = $request->has('delegated') && ! empty($delegatedTo);

        $saveData = [
            'first_name' => $dealer->first_name,
            'last_name' => $dealer->last_name,
            'delegated_to' => $delegatedTo,
            'number_of_corrugators' => $request->input('number_of_corrugators', ''),
            'total_belt_market_size_m2' => $request->input('total_belt_market_size_m2', ''),
            'ms_market_share_pct' => $request->input('ms_market_share_pct', ''),
            'competitor_a_name' => $request->input('competitor_a_name', ''),
            'competitor_a_pct' => $request->input('competitor_a_pct', ''),
            'competitor_b_name' => $request->input('competitor_b_name', ''),
            'competitor_b_pct' => $request->input('competitor_b_pct', ''),
            'competitor_c_name' => $request->input('competitor_c_name', ''),
            'competitor_c_pct' => $request->input('competitor_c_pct', ''),
            'others_market_share_pct' => $request->input('others_market_share_pct', ''),
            'order_situation' => $request->input('order_situation', ''),
            'price_level' => $request->input('price_level', ''),
            'capacity_utilization' => $request->input('capacity_utilization', ''),
            'machine_investments' => $request->input('machine_investments', ''),
            'role_of_large_groups' => $request->input('role_of_large_groups', ''),
            'swot_strengths' => $request->input('swot_strengths', ''),
            'swot_weaknesses' => $request->input('swot_weaknesses', ''),
            'swot_opportunities' => $request->input('swot_opportunities', ''),
            'swot_threats' => $request->input('swot_threats', ''),
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
            'number_of_corrugators' => 'Please enter the Number of Corrugators.',
            'total_belt_market_size_m2' => 'Please enter the Total Belt Market Size.',
            'ms_market_share_pct' => 'Please enter the Mühlen Sohn Market Share.',
            'competitor_a_name' => 'Please enter the name of Competitor A.',
            'competitor_a_pct' => 'Please enter the market share of Competitor A.',
            'competitor_b_name' => 'Please enter the name of Competitor B.',
            'competitor_b_pct' => 'Please enter the market share of Competitor B.',
            'competitor_c_name' => 'Please enter the name of Competitor C.',
            'competitor_c_pct' => 'Please enter the market share of Competitor C.',
            'others_market_share_pct' => 'Please enter the Others Market Share.',
            'order_situation' => 'Please fill in the Order Situation field.',
            'price_level' => 'Please fill in the Price Level field.',
            'capacity_utilization' => 'Please fill in the Capacity Utilization field.',
            'machine_investments' => 'Please fill in the Machine Investments field.',
            'role_of_large_groups' => 'Please fill in the Role of Large Groups field.',
            'swot_strengths' => 'Please fill in the Strengths field.',
            'swot_weaknesses' => 'Please fill in the Weaknesses field.',
            'swot_opportunities' => 'Please fill in the Opportunities field.',
            'swot_threats' => 'Please fill in the Threats field.',
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
