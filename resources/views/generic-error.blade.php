@extends('layouts.app')

@section('title', 'Hiba történt')

@if (!$errors->any())
    Váratlan hiba történt!
@endif