<?php

namespace App\Http\Controllers;

use \Auth;
use App\Vizsga;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function show()
    {
        $vizsgak = Auth::user()->vizsgas;
        
        return view('vizsgaztato.dashboard', ['vizsgak' => $vizsgak]);
    }

    public function vizsgaReszletek($vizsgaId)
    {
        $vizsga = Vizsga::find($vizsgaId);
        if (!$vizsga)
            return redirect()->route('error');

        if (!$vizsga->user->is(Auth::user()))
            return redirect()->route('error');

        return view('vizsgaztato.vizsga-reszletek', ['vizsga' => $vizsga]);
    }

}
