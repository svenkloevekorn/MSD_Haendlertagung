<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class SpeakerController extends Controller
{
    public function image(Speaker $speaker): Response
    {
        if ($speaker->status !== 'live' || ! $speaker->image_path) {
            abort(404);
        }

        return Storage::disk('local')->response($speaker->image_path);
    }
}
