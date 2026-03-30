<?php

namespace App\Http\Controllers;

use App\Models\ContactPerson;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    public function index(): View
    {
        $contacts = ContactPerson::live()
            ->orderBy('sort_order')
            ->get();

        return view('kontakt', compact('contacts'));
    }

    public function image(ContactPerson $contactPerson): Response
    {
        if ($contactPerson->status !== 'live' || ! $contactPerson->image_path) {
            abort(404);
        }

        return Storage::disk('local')->response($contactPerson->image_path);
    }
}
