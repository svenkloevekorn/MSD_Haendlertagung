<?php

namespace App\Http\Controllers;

use App\Models\FormSubmission;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    private const CATEGORIES = ['accommodation', 'catering', 'program', 'presentations', 'organisation', 'further'];

    public function show(): View
    {
        return view('feedback');
    }

    public function submit(Request $request): RedirectResponse
    {
        $rules = [
            'rating' => 'required|in:1,2,3,4',
            'liked' => 'nullable|string|max:2000',
            'improve' => 'nullable|string|max:2000',
            'topics' => 'nullable|string|max:2000',
            'additional_comments' => 'nullable|string|max:2000',
        ];

        foreach (self::CATEGORIES as $cat) {
            $rules["rating_{$cat}"] = 'nullable|in:1,2,3,4';
            $rules["comment_{$cat}"] = 'nullable|string|max:2000';
        }

        $validated = $request->validate($rules);

        $data = [
            'rating' => $validated['rating'],
        ];

        foreach (self::CATEGORIES as $cat) {
            $data["rating_{$cat}"] = $validated["rating_{$cat}"] ?? '';
            $data["comment_{$cat}"] = $validated["comment_{$cat}"] ?? '';
        }

        $data['liked'] = $validated['liked'] ?? '';
        $data['improve'] = $validated['improve'] ?? '';
        $data['topics'] = $validated['topics'] ?? '';
        $data['additional_comments'] = $validated['additional_comments'] ?? '';

        FormSubmission::create([
            'form_slug' => FormSubmission::FORM_FEEDBACK,
            'dealer_id' => session('dealer_id'),
            'data' => $data,
        ]);

        $confirmation = Setting::get(
            'confirmation_feedback',
            'Thank you for your feedback!'
        );

        return redirect()->route('feedback')->with('success', $confirmation);
    }
}
