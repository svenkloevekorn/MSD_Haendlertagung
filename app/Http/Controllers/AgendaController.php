<?php

namespace App\Http\Controllers;

use App\Models\AgendaDay;
use App\Models\Speaker;
use Illuminate\View\View;

class AgendaController extends Controller
{
    public function index(): View
    {
        $days = AgendaDay::with('items')
            ->orderBy('sort_order')
            ->get();

        $speakers = Speaker::live()
            ->orderBy('sort_order')
            ->get();

        return view('agenda', compact('days', 'speakers'));
    }
}
