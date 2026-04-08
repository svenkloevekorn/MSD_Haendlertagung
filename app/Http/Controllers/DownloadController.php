<?php

namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function index()
    {
        $downloads = Download::live()->orderBy('sort_order')->orderBy('name')->get();

        return view('downloads', compact('downloads'));
    }

    public function file(Download $download)
    {
        if ($download->status !== 'live') {
            abort(404);
        }

        if (! Storage::disk('local')->exists($download->file_path)) {
            abort(404);
        }

        $download->increment('download_count');

        return Storage::disk('local')->download($download->file_path, $download->original_filename);
    }
}
