<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use Illuminate\Http\Request;

class PinLoginController extends Controller
{
    public function show()
    {
        if (session('dealer_id')) {
            return redirect('/startseite');
        }

        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'pin' => 'required|string|size:6|alpha_num',
        ]);

        $dealer = Dealer::whereRaw('LOWER(pin) = ?', [strtolower($request->input('pin'))])->first();

        if (! $dealer) {
            return back()->withErrors(['pin' => 'Ungültiger Zugangscode.']);
        }

        $dealer->update(['last_login_at' => now()]);

        session([
            'dealer_id' => $dealer->id,
            'dealer_logged_in_at' => now()->timestamp,
        ]);

        return redirect('/startseite');
    }

    public function logout()
    {
        session()->forget(['dealer_id', 'dealer_logged_in_at']);

        return redirect('/');
    }
}
