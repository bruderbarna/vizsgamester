@extends('layouts.app')

@section('title', 'Vizsga összegzés')

@section('content')
    @if (isset($vizsgaztato) && $vizsgaztato === true)
        <a href="{{ url()->previous() }}">Vissza</a>
    @endif
    Tárgy neve: {{ $vizsgazas->vizsga->targy_nev }}<br />
    Vizsgáztató neve: {{ $vizsgazas->vizsga->user->name }}<br />
    Név: {{ $vizsgazas->name }}<br />
    Neptun kód: {{ $vizsgazas->neptun }}<br />
    Kérdések száma: {{ $vizsgazas->vizsga->kerdes->count() }}<br />
    Megválaszolt kérdések száma: {{ $vizsgazas->valaszs->count() }}<br />
    Elért pontszám: {{ $vizsgazas->getElertPontszam() }}<br />
    Százalékos érték: {{ number_format($vizsgazas->getSzazalek(), 2) }}<br />
    Jegy: {{ $vizsgazas->getJegy() }}<br />

    <hr>
    @foreach ($vizsgazas->valaszs as $valasz)
        {{ $valasz->kerdes->kerdesszam }}. kérdés<br />
        {{ $valasz->kerdes->description }}
        <ul>
            @foreach ($valasz->kerdes->valaszLehetosegs as $vl)
                <li>
                    {{ $vl-> description }}
                    @if ($valasz->valaszLehetoseg->id === $vl->id)
                        <span class="chosen">chosen</span>
                    @endif 
                    @if ($vl->helyes === 1)
                        <span class="correct">c</span>
                    @else
                        <span class="incorrect">inc</span>
                    @endif
                </li>
            @endforeach
        </ul>
        <hr>
    @endforeach
@endsection