@extends('layouts.app')

@section('title', 'Vizsga részletek')

@section('content')
    <ul>
        <li>Tárgy neve: {{ $vizsga->targy_nev }}</li>
        <li>Vizsgáztató neve: {{ $vizsga->user->name }}</li>
        <li>Vizsga időtartam: {{ $vizsga->vizsga_idotartam }}</li>
        <li>Kérdések száma: {{ $vizsga->kerdes->count() }}</li>
        <li>Vizsga időintervallum: {{ $vizsga->tol }} - {{ $vizsga->ig }}</li>
    </ul>
    @if ($vizsga->canTakeNow())
        <form action="/startvizsga" method="POST">
            @csrf
            <input name="vizsgakod" type="hidden" value="{{ $vizsga->vizsgakod }}">
            Név: <input name="name" type="text">
            Neptun kód: <input name="neptun" type="text">
            <button type="submit">Kezdés</button>
        </form>
    @elseif ($vizsga->lateToTake())
        A vizsgát már nem lehet kitölteni, mert a vizsga időintervallum múltbéli.
    @elseif ($vizsga->earlyToTake())
        A vizsgát még nem lehet kitölteni, mert a vizsga időintervallum jövőbéli.
    @endif
@endsection