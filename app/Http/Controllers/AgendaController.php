<?php

namespace App\Http\Controllers;

use App\Models\AgendaDay;
use Illuminate\View\View;

class AgendaController extends Controller
{
    public function index(): View
    {
        $days = AgendaDay::with('items')
            ->orderBy('sort_order')
            ->get();

        return view('agenda', compact('days'));
    }
}
