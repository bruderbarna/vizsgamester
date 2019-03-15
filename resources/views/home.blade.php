@extends('layouts.app')

@section('title', 'Főoldal')

@section('content')
    <a href="{{ route('login') }}">Bejelentkezés (vizsgáztató/admin)</a>

    <form id="form">
        @csrf
        <input type="text" id="vizsgakod">
        <button type="submit">Küldés</button>
        <div id="form-error-message"></div>
    </form>

    <script>
        (function () {
            var vizsgakodInput = document.getElementById('vizsgakod');
            var form = document.getElementById('form');
            var errorMsgHolder = document.getElementById('form-error-message');

            var error = function (errorMsg) {
                if (!errorMsg) {
                    errorMsgHolder.style.display = 'none';
                } else {
                    errorMsgHolder.style.display = 'block';
                    errorMsgHolder.innerHTML = errorMsg;
                }
            };

            form.onsubmit = function (e) {
                e.preventDefault();

                if (vizsgakodInput.value) {
                    error();
                    window.location.href = '/previzsga/' + vizsgakodInput.value;
                } else {
                    error('Vizsgakód mező kitöltése kötelező.');
                }
            };
        })();
    </script>
@endsection