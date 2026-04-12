<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Models\FormSubmission;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    private const STAR_CATEGORIES = ['accommodation', 'catering', 'program', 'presentations', 'organisation'];

    public function show(): View
    {
        $dealer = Dealer::find(session('dealer_id'));
        $submission = FormSubmission::where('form_slug', FormSubmission::FORM_FEEDBACK)
            ->where('dealer_id', $dealer->id)
            ->first();

        $saved = $submission?->data ?? [];
        $isComplete = $this->isComplete($saved);

        return view('feedback', compact('saved', 'isComplete'));
    }

    public function submit(Request $request): RedirectResponse
    {
        $dealer = Dealer::find(session('dealer_id'));

        $data = [
            'rating' => $request->input('rating', ''),
        ];

        foreach (self::STAR_CATEGORIES as $cat) {
            $data["rating_{$cat}"] = $request->input("rating_{$cat}", '');
            $data["comment_{$cat}"] = $request->input("comment_{$cat}", '');
        }

        $data['comment_further'] = $request->input('comment_further', '');
        $data['liked'] = $request->input('liked', '');
        $data['improve'] = $request->input('improve', '');
        $data['topics'] = $request->input('topics', '');
        $data['additional_comments'] = $request->input('additional_comments', '');

        FormSubmission::updateOrCreate(
            [
                'form_slug' => FormSubmission::FORM_FEEDBACK,
                'dealer_id' => $dealer->id,
            ],
            ['data' => $data]
        );

        // Check for missing required fields
        $missing = [];
        if (empty($data['rating'])) {
            $missing['rating'] = 'Please select an overall rating.';
        }
        $labels = [
            'accommodation' => 'Accommodation',
            'catering' => 'Food & Catering',
            'program' => 'Program',
            'presentations' => 'Presentations',
            'organisation' => 'Organisation',
        ];
        foreach (self::STAR_CATEGORIES as $cat) {
            if (empty($data["rating_{$cat}"])) {
                $missing["rating_{$cat}"] = 'Please rate ' . $labels[$cat] . '.';
            }
        }
        foreach (['liked', 'improve', 'topics'] as $field) {
            if (empty($data[$field])) {
                $missing[$field] = 'Please fill in this field.';
            }
        }

        if (! empty($missing)) {
            return redirect()->route('feedback')
                ->withErrors($missing)
                ->withInput();
        }

        $confirmation = Setting::get(
            'confirmation_feedback',
            'Thank you for your feedback!'
        );

        return redirect()->route('feedback')->with('success', $confirmation);
    }

    private function isComplete(array $data): bool
    {
        if (empty($data['rating'] ?? null)) return false;
        foreach (self::STAR_CATEGORIES as $cat) {
            if (empty($data["rating_{$cat}"] ?? null)) return false;
        }
        foreach (['liked', 'improve', 'topics'] as $field) {
            if (empty($data[$field] ?? null)) return false;
        }
        return true;
    }
}
