<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\FormSubmission;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function show(): View
    {
        $dealer = Dealer::find(session('dealer_id'));
        $submission = FormSubmission::where('form_slug', FormSubmission::FORM_REGISTRATION)
            ->where('dealer_id', $dealer->id)
            ->first();

        $saved = $submission?->data ?? [];

        return view('formular', compact('saved'));
    }

    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'mobile' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'no_companion' => 'nullable|in:true',
            'companion_mobile' => 'nullable|string|max:255',
            'no_allergies' => 'nullable|in:true',
            'allergies' => 'nullable|string|max:1000',
            'factory_tour' => 'nullable|in:yes,no',
            'comments' => 'nullable|string|max:2000',
        ]);

        $dealer = Dealer::find(session('dealer_id'));

        $data = [
            'first_name' => $dealer->first_name,
            'last_name' => $dealer->last_name,
            'email' => $dealer->email,
            'mobile' => $validated['mobile'] ?? '',
            'company' => $validated['company'] ?? '',
            'no_companion' => $validated['no_companion'] ?? '',
            'companion_mobile' => $validated['companion_mobile'] ?? '',
            'no_allergies' => $validated['no_allergies'] ?? '',
            'allergies' => $validated['allergies'] ?? '',
            'factory_tour' => $validated['factory_tour'] ?? '',
            'comments' => $validated['comments'] ?? '',
        ];

        FormSubmission::updateOrCreate(
            [
                'form_slug' => FormSubmission::FORM_REGISTRATION,
                'dealer_id' => $dealer->id,
            ],
            ['data' => $data]
        );

        $confirmation = Setting::get(
            'confirmation_registration',
            'Your registration has been saved!'
        );

        return redirect()->route('formular')->with('success', $confirmation);
    }
}
