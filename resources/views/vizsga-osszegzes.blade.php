@extends('layouts.app')

@section('title', 'Vizsga összegzés')

@section('content')
    Tárgy neve: {{ $vm->targyNeve }}<br />
    Vizsgáztató neve: {{ $vm->vizsgaztatoNeve }}<br />
    Név: {{ $vm->name }}<br />
    Neptun kód: {{ $vm->neptun }}<br />
    Kérdések száma: {{ $vm->kerdesekSzama }}<br />
    Megválaszolt kérdések száma: {{ $vm->megvalaszoltKerdesekSzama }}<br />
    Elért pontszám: {{ $vm->elertPontokSzama }}<br />
    Százalékos érték: {{ number_format($vm->szazalek, 2) }}<br />
    Jegy: {{ $vm->jegy }}<br />

    <hr>
    @foreach ($vm->valaszok as $valasz)
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