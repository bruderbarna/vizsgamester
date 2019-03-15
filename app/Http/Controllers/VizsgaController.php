<?php

namespace App\Http\Controllers;

use App\Kerdes;
use App\Valasz;
use App\Vizsga;
use App\Vizsgazas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class VizsgaController extends Controller
{

    public function preVizsga($vizsgakod)
    {
        $validator = Validator::make(
            ['vizsgakod' => $vizsgakod],
            ['vizsgakod' => 'required|exists:vizsgas'],
            Config::get('constants.VALIDATION_ERROR_STRINGS')
        );

        if ($validator->fails())
            return redirect()->home()->withErrors(array('Helytelen vizsgakód. Ilyen kódú vizsga nem létezik.'));

        $vizsga = Vizsga::with('kerdes.valaszLehetosegs')
                             ->where('vizsgakod', $vizsgakod)
                             ->first();

        return view('previzsga', ['vizsga' => $vizsga]);
    }

    public function startVizsga(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [ 'vizsgakod' => 'exists:vizsgas|required', 'name' => 'required', 'neptun' => 'required' ],
            Config::get('constants.VALIDATION_ERROR_STRINGS')
        );

        if ($validator->fails())
            return back()->withInput()->withErrors($validator);

        $vizsgakod = $request->vizsgakod;

        $vizsgazas = new Vizsgazas;
        $vizsgazas->name = $request->name;
        $vizsgazas->neptun = $request->neptun;
        $vizsgazas->vizsga_id =
            Vizsga::where('vizsgakod', $vizsgakod)->firstOrFail()->id;
        $vizsgazas->kezdet = new \DateTime();
        $vizsgazas->current_kerdes = 1;
        $vizsgazas->vizsga_secret = $this->getUniqueVizsgaSecret();

        if (!$vizsgazas->vizsga->canTakeNow())
            return redirect()->route('error')->withErrors(
                array('A vizsgát ebben az időpillanatban nem lehet kitölteni, mert ' +
                      'nem vagyunk a vizsgáztató által kitűzött időintervallumban.')
            );

        $saveSuccess = $vizsgazas->save();
        if (!$saveSuccess)
            return redirect()->route('error');

        return redirect()->route('showKerdes', ['vizsgazasId' => $vizsgazas->id, 'kerdesszam' => $vizsgazas->current_kerdes])
                       ->withCookie(cookie(Config::get('constants.VIZSGA_SECRET_KEY'), $vizsgazas->vizsga_secret));
    }

    public function showKerdes($vizsgazasId, $kerdesszam)
    {
        $validator = Validator::make(
            ['vizsgazasId' => $vizsgazasId, 'kerdesszam' => $kerdesszam],
            ['vizsgazasId' => 'required|integer', 'kerdesszam' => 'required|integer|min:1'],
            Config::get('constants.VALIDATION_ERROR_STRINGS')
        );
        if ($validator->fails())
            return redirect()->route('error')->withErrors($validator);

        $vizsgazas = Vizsgazas::with('vizsga.kerdes.valaszLehetosegs')->find($vizsgazasId);
        if ($vizsgazas === null)
            return redirect()->route('error');

        if (!$vizsgazas->canContinue())
            return redirect()->route('vizsgaOsszegzes', ['vizsgazasId' => $vizsgazas->id])->with([
                'warning-alerts' => array('A kérdést, ami következett volna, már nem nézhetted meg, mert kifutottál a vizsga időtartamából.')
            ]);
        
        if (!$vizsgazas->vizsga->canTakeNow())
            return redirect()->route('vizsgaOsszegzes', ['vizsgazasId' => $vizsgazas->id])->with([
                'warning-alerts' => array('A kérdést, ami következett volna, már nem nézhetted meg, mert kifutottál a vizsga időintervallumból.')
            ]);

        if ($vizsgazas->current_kerdes != $kerdesszam)
            return redirect()->route('recoverableKerdesError', [
                "kerdesszam" => $vizsgazas->current_kerdes,
                'vizsgazasId' => $vizsgazas->id
            ]);

        $vizsgaSecret = Cookie::get(Config::get('constants.VIZSGA_SECRET_KEY'));
        if ($vizsgazas->vizsga_secret !== $vizsgaSecret)
            return redirect()->route('error');

        $kerdesszam = (int) $kerdesszam;
        $kerdesek = $vizsgazas->vizsga->kerdes;
        $kerdes = $kerdesek->first(function ($kerdes) use ($kerdesszam) {
                                       return $kerdes->kerdesszam === $kerdesszam;
                                   });
        
        if ($kerdes === null)
            return redirect()->route('error');

        return view('kerdes', [
            'kerdes' => $kerdes,
            'valaszLehetosegek' => $kerdes->valaszLehetosegs->all(),
            'vizsgazas' => $vizsgazas
        ]);
    }

    public function valasz(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kerdesszam' => 'required|integer|min:1',
                'kerdes_id' => 'exists:kerdes,id|required|integer',
                'vizsgazas_id' => 'exists:vizsgazas,id|required|integer',
                'valasz_lehetoseg_id' => 'exists:valasz_lehetosegs,id|required|integer'
            ],
            Config::get('constants.VALIDATION_ERROR_STRINGS')
        );

        if ($validator->fails())
            return redirect()->route('error');

        $kerdesszam = (int) $request->kerdesszam;

        $valasz = new Valasz;
        $valasz->vizsgazas_id = $request->vizsgazas_id;

        if (!$valasz->vizsgazas->canContinue())
            return redirect()->route('vizsgaOsszegzes', ['vizsgazasId' => $vizsgazas->id])->with([
                'warning-alerts' => array('A legutóbb megadott válaszodat már nem mentettük el, mert kifutottál a vizsga időtartamból.')
            ]);

        if (!$valasz->vizsgazas->vizsga->canTakeNow())
            return redirect()->route('vizsgaOsszegzes', ['vizsgazasId' => $vizsgazas->id])->with([
                'warning-alerts' => array('A legutóbb megadott válaszodat már nem mentettük el, mert kifutottál a vizsga időintervallumból.')
            ]);

        if ($kerdesszam !== $valasz->vizsgazas->current_kerdes)
            return redirect()->route('recoverableKerdesError', [
                "kerdesszam" => $vizsgazas->current_kerdes,
                'vizsgazasId' => $vizsgazas->id
            ]);

        $vizsgaSecret = Cookie::get(Config::get('constants.VIZSGA_SECRET_KEY'));
        if ($valasz->vizsgazas->vizsga_secret !== $vizsgaSecret)
            return redirect()->route('error');

        $valasz->kerdes_id = $request->kerdes_id;
        $valasz->valasz_lehetoseg_id = $request->valasz_lehetoseg_id;

        $saveSuccess = $valasz->save();
        if (!$saveSuccess)
            return redirect()->route('error');

        $vizsgaKerdesekSzama = $valasz->kerdes->vizsga->kerdes->count();
        if ($kerdesszam < $vizsgaKerdesekSzama)
        {
            $valasz->vizsgazas->current_kerdes++;
            $saveSuccess = $valasz->vizsgazas->save();
            if (!$saveSuccess)
                return redirect()->route('error');

            return redirect()->route('showKerdes', ['vizsgazasId' => $valasz->vizsgazas_id, 'kerdesszam' => $valasz->vizsgazas->current_kerdes]);
        }
        else if ($kerdesszam === $vizsgaKerdesekSzama)
            return redirect()->route('vizsgaOsszegzes', ['vizsgazasId' => $valasz->vizsgazas_id]);
        else
            return redirect()->route('error');
    }

    public function vizsgaOsszegzes($vizsgazasId)
    {
        $validator = Validator::make(
            ['vizsgazasId' => $vizsgazasId],
            ['vizsgazasId' => 'required|exists:vizsgazas,id'],
            Config::get('constants.VALIDATION_ERROR_STRINGS')
        );

        $vizsgazas = Vizsgazas::find($vizsgazasId);

        $vizsgaSecret = Cookie::get(Config::get('constants.VIZSGA_SECRET_KEY'));
        if ($vizsgazas->vizsga_secret !== $vizsgaSecret)
            return redirect()->route('error');

        $vm = new \stdClass();
        $vm->name = $vizsgazas->name;
        $vm->neptun = $vizsgazas->neptun;
        $vm->kerdesekSzama = $vizsgazas->vizsga->kerdes->count();
        $vm->megvalaszoltKerdesekSzama = $vizsgazas->valaszs->count();
        $vm->elertPontokSzama = $vizsgazas->getElertPontszam();
        $vm->szazalek = $vizsgazas->getSzazalek();
        $vm->jegy = $vizsgazas->getJegy();
        $vm->valaszok = $vizsgazas->valaszs;
        $vm->targyNeve = $vizsgazas->vizsga->targy_nev;
        $vm->vizsgaztatoNeve = $vizsgazas->vizsga->user->name;

        return view('vizsga-osszegzes', ['vm' => $vm]);
    }

    private function getUniqueVizsgaSecret()
    {
        $secrets = Vizsgazas::pluck('vizsga_secret')->toArray();

        $rand;
        do
        {
            $rand = $this->randomHex(30);
        } while (in_array($rand, $secrets));

        return $rand;
    }

    private function randomHex($length)
    {
        return bin2hex(\openssl_random_pseudo_bytes((int) ($length / 2)));
    }

}
