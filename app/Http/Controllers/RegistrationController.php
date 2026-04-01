<?php

namespace App\Http\Controllers;

use App\Models\FormSubmission;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function show(): View
    {
        return view('formular');
    }

    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'has_companion' => 'nullable',
            'companion_first_name' => 'nullable|string|max:255',
            'companion_last_name' => 'nullable|string|max:255',
            'allergies' => 'nullable|string|max:1000',
            'factory_tour' => 'nullable',
            'whatsapp' => 'nullable',
            'comments' => 'nullable|string|max:2000',
        ]);

        $data = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'company' => $validated['company'] ?? '',
            'has_companion' => isset($validated['has_companion']),
            'companion_first_name' => $validated['companion_first_name'] ?? '',
            'companion_last_name' => $validated['companion_last_name'] ?? '',
            'allergies' => $validated['allergies'] ?? '',
            'factory_tour' => isset($validated['factory_tour']),
            'whatsapp' => isset($validated['whatsapp']),
            'comments' => $validated['comments'] ?? '',
        ];

        FormSubmission::create([
            'form_slug' => FormSubmission::FORM_REGISTRATION,
            'dealer_id' => session('dealer_id'),
            'data' => $data,
        ]);

        $confirmation = Setting::get(
            'confirmation_registration',
            'Thank you for your registration!'
        );

        return redirect()->route('formular')->with('success', $confirmation);
    }
}
