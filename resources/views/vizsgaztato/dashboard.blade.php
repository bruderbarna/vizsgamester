@extends('layouts.app')

@section('title', 'Vizsgáztató dashboard')

@section('content')
    <h3>Vizsgák</h3>
    @if ($vizsgak->isEmpty())
        Jelenleg nincsenek felvitt vizsgái.
    @else
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Tárgy neve</th>
                    <th scope="col">Vizsga időintervallum</th>
                    <th scope="col">Kitöltések száma</th>
                    <th scope="col">Műveletek</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vizsgak as $vizsga)
                    <tr>
                        <td>{{ $vizsga->targy_nev }}</td>
                        <td>{{ $vizsga->tol }} - {{ $vizsga->ig }}</td>
                        <td>{{ $vizsga->vizsgazass->count() }}</td>
                        <td><a href="{{ route('vizsgaReszletek', ['vizsgaId' => $vizsga->id]) }}">Részletek</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection