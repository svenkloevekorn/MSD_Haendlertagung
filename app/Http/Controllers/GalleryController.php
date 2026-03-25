<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $images = GalleryImage::live()->orderBy('sort_order')->orderBy('created_at', 'desc')->get();

        $imagesJson = $images->map(function ($img) {
            return [
                'src' => route('galerie.image', $img),
                'title' => $img->title,
                'description' => $img->description,
            ];
        })->values();

        return view('galerie', compact('images', 'imagesJson'));
    }

    public function show(GalleryImage $galleryImage)
    {
        if ($galleryImage->status !== 'live') {
            abort(404);
        }

        if (! Storage::disk('local')->exists($galleryImage->image_path)) {
            abort(404);
        }

        return Storage::disk('local')->response($galleryImage->image_path);
    }
}
