@extends('layouts.app')

@section('title', 'Új vizsga létrehozása')

@section('content')
    <a href="{{ url()->previous() }}">Vissza</a>
    {{ Form::model($vizsga, array('url' => '/vizsga-modositas')) }}
        {!! Form::hidden('vizsgaId', $vizsga->id) !!}
        @include('layouts.create-edit-vizsga-form', ['tol' => $vizsga->tol, 'ig' => $vizsga->ig])
    {{ Form::close() }}
@endsection