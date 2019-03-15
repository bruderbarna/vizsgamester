
@extends('layouts.app')

@section('title', 'Bejelentkezés')

@section('content')
    <form action="{{ route('loginPost') }}" method="post">
        @csrf
        <input type="text" name="email">
        <input type="password" name="password">
        <button type="submit">Küldés</button>
    </form>
@endsection