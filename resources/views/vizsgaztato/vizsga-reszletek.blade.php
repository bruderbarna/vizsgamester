@extends('layouts.app')

@section('title', 'Vizsga részletek')

@section('content')
    <a href="{{ route('dashboard') }}">Vissza</a>
    <ul>
        <li>Tárgy neve: {{ $vizsga->targy_nev }}</li>
        <li>Vizsgáztató neve: {{ $vizsga->user->name }}</li>
        <li>Vizsga időtartam: {{ $vizsga->vizsga_idotartam }}</li>
        <li>Kérdések száma: {{ $vizsga->kerdes->count() }}</li>
        <li>Vizsga időintervallum: {{ $vizsga->tol }} - {{ $vizsga->ig }}</li>
        <li>Vizsgakód: {{ $vizsga->vizsgakod }}</li>
    </ul>
    <h3>Vizsga kitöltések</h3>
    @if ($vizsga->vizsgazass->isEmpty())
        Jelenleg nincsenek kitöltések.
    @else
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Név</th>
                    <th scope="col">Neptun kód</th>
                    <th scope="col">Helyes válaszok</th>
                    <th scope="col">Százalék</th>
                    <th scope="col">Jegy</th>
                    <th scope="col">Műveletek</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vizsga->vizsgazass as $vizsgazas)
                    <tr>
                        <td>{{ $vizsgazas->name }}</td>
                        <td>{{ $vizsgazas->neptun }}</td>
                        <td>{{ $vizsgazas->getElertPontszam() }}/{{ $vizsgazas->vizsga->kerdes->count() }}</td>
                        <td>{{ $vizsgazas->getSzazalek() }}</td>
                        <td>{{ $vizsgazas->getJegy() }}</td>
                        <td><a href="{{ route('vizsgaKitoltesReszletek', ['vizsgazasId' => $vizsgazas->id]) }}">Részletek</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection