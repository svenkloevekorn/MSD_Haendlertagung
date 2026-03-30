<?php

namespace App\Http\Controllers;

use App\Models\FormSubmission;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    public function show(): View
    {
        return view('feedback');
    }

    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'rating' => 'required|in:2,3,4,5',
            'liked' => 'nullable|string|max:2000',
            'improve' => 'nullable|string|max:2000',
            'topics' => 'nullable|string|max:2000',
            'additional_comments' => 'nullable|string|max:2000',
        ]);

        FormSubmission::create([
            'form_slug' => FormSubmission::FORM_FEEDBACK,
            'data' => [
                'rating' => $validated['rating'],
                'liked' => $validated['liked'] ?? '',
                'improve' => $validated['improve'] ?? '',
                'topics' => $validated['topics'] ?? '',
                'additional_comments' => $validated['additional_comments'] ?? '',
            ],
        ]);

        $confirmation = Setting::get(
            'confirmation_feedback',
            'Thank you for your feedback!'
        );

        return redirect()->route('feedback')->with('success', $confirmation);
    }
}
