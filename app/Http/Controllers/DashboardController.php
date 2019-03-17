<?php

namespace App\Http\Controllers;

use \Auth;
use App\Vizsga;
use App\Vizsgazas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function vizsgaKitoltesReszletek($vizsgazasId)
    {
        $vizsgazas = Vizsgazas::find($vizsgazasId);
        if (!$vizsgazas)
            return redirect()->route('error');

        if (!$vizsgazas->vizsga->user->is(Auth::user()))
            return redirect()->route('error');

        return view('vizsga-osszegzes', ['vizsgazas' => $vizsgazas, 'vizsgaztato' => true]);
    }

    public function newVizsgaForm()
    {
        return view('vizsgaztato.create-vizsga');
    }

    public function createVizsga(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'targy_nev' => 'required|filled',
                'vizsga_idotartam' => 'required|integer|min:3',
                'tol' => 'required|date|after:now',
                'ig' => 'required|date|after:tol'
            ]
        );

        if ($validator->fails())
            return back()->withInput()->withErrors($validator);

        $vizsga = Vizsga::create($request->all());
        $vizsga->vizsgakod = $this->getUniqueVizsgakod();

        $saveSuccess = $vizsga->save();
        if (!$saveSuccess)
            return redirect()->route('error');

        return redirect()->route('vizsgaReszletek', ['vizsgaId' => $vizsga->id]);
    }

    private function getUniqueVizsgakod()
    {
        $vizsgakodok = Vizsga::pluck('vizsgakod')->toArray();

        
        $rand;
        do
        {
            $rand = $this->randomHex(10);
        } while (in_array($rand, $vizsgakodok));

        return $rand;
    }

    private function randomHex($length)
    {
        return bin2hex(\openssl_random_pseudo_bytes((int) ($length / 2)));
    }

}
