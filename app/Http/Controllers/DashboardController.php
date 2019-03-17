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

    public function vizsgaModositasForm($vizsgaId)
    {
        $vizsga = Vizsga::find($vizsgaId);
        if (!$vizsga)
            return redirect()->route('error');

        if (!$vizsga->user->is(Auth::user()))
            return redirect()->route('error');

        return view('vizsgaztato.edit-vizsga', ['vizsga' => $vizsga]);
    }

    public function vizsgaModositas(Request $request)
    {
        $validator = $this->makeVizsgaValidator($request->all());

        if ($validator->fails())
            return back()->withInput()->withErrors($validator);

        $vizsga = Vizsga::find($request->vizsgaId);
        $vizsga->fill($request->all());
        if (!$vizsga->save())
            return redirect()->route('error');

        return redirect()->route('vizsgaReszletek', ['vizsgaId' => $vizsga->id]);
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
        $validator = $this->makeVizsgaValidator($request->all());

        if ($validator->fails())
            return back()->withInput()->withErrors($validator);

        $vizsga = new Vizsga;
        $vizsga->fill($request->all());
        $vizsga->vizsgakod = $this->getUniqueVizsgakod();
        $vizsga->user()->associate(Auth::user());

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

    private function makeVizsgaValidator(array $inputs)
    {
        return Validator::make(
            $inputs,
            [
                'vizsgaId' => 'exists:vizsgas,id',
                'targy_nev' => 'required|filled',
                'vizsga_idotartam' => 'required|integer|min:3',
                'tol' => 'required|date|after:now',
                'ig' => 'required|date|after:tol'
            ]
        );
    }

}
