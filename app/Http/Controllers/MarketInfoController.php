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
            'machine_width_lt_22' => $request->input('machine_width_lt_22', ''),
            'machine_width_22_24' => $request->input('machine_width_22_24', ''),
            'machine_width_25_27' => $request->input('machine_width_25_27', ''),
            'machine_width_28_30' => $request->input('machine_width_28_30', ''),
            'machine_width_gt_30' => $request->input('machine_width_gt_30', ''),
            'machine_speed_lt_60' => $request->input('machine_speed_lt_60', ''),
            'machine_speed_60_100' => $request->input('machine_speed_60_100', ''),
            'machine_speed_100_150' => $request->input('machine_speed_100_150', ''),
            'machine_speed_150_200' => $request->input('machine_speed_150_200', ''),
            'machine_speed_200_300' => $request->input('machine_speed_200_300', ''),
            'machine_speed_gt_300' => $request->input('machine_speed_gt_300', ''),
            'owner_groups_pct' => $request->input('owner_groups_pct', ''),
            'owner_independents_pct' => $request->input('owner_independents_pct', ''),
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

        $confirmation = Setting::get('confirmation_market_info', 'Your market information has been saved!');

        // Form already saved above. If required fields are missing, show non-blocking warning.
        if (! FormSubmission::isMarketInfoComplete($saveData)) {
            return redirect()->route('market-info')
                ->with('warning', 'Your entries have been saved, but some required fields are still empty. Please complete them before the deadline.');
        }

        return redirect()->route('market-info')->with('success', $confirmation);
    }
}
