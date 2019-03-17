@extends('layouts.app')

@section('title', 'Új vizsga létrehozása')

@section('content')
    {{ Form::open(array('url' => '/create-vizsga')) }}
        @include('layouts.create-edit-vizsga-form')
    {{ Form::close() }}
@endsection