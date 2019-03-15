@extends('layouts.app')

@section('title', 'Hiba')

@section('content')
    Hiba történt, de 
    <a href="{{ route('showKerdes', ['vizsgazasId' => $vizsgazasId, 'kerdesszam' => $kerdesszam]) }}">
        ide kattintva
    </a> 
    visszatérhetsz a vizsgázáshoz!
@endsection