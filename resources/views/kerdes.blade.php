@extends('layouts.app')

@section('title', 'Kérdés')

@section('content')
    <h4>{{ $kerdes->description }}</h4>
    <hr />
    <form action="/valasz" method="post" id="form">
        @csrf
        <input type="hidden" name="vizsgazas_id" value="{{ $vizsgazas->id }}">
        <input type="hidden" name="kerdes_id" value="{{ $kerdes->id }}">
        <input type="hidden" name="kerdesszam" value="{{ $kerdes->kerdesszam }}">
        @foreach ($valaszLehetosegek as $valaszLehetoseg)
            <label>
                <input type="radio" class="valasz-radio" name="valasz_lehetoseg_id" value="{{ $valaszLehetoseg->id }}">
                {{ $valaszLehetoseg->description }}
            </label>
            <br />
        @endforeach
        <button id="button">Küldés</button>
        <div id="error" style="display: none;">Legalább egy lehetőséget kötelező kiválasztani</div>
    </form>
    <script>
        (function () {
            var form = document.getElementById('form');
            var error = document.getElementById('error');

            var aRadioIsChecked = function () {
                var radios = document.getElementsByClassName('valasz-radio');

                for (var radio of radios) {
                    if (radio.checked)
                        return true;
                }

                return false;
            }

            var showError = function () { error.style.display = 'block'; };
            var hideError = function () { error.style.display = 'none'; };

            var button = document.getElementById('button');
            button.onclick = function (e) {
                e.preventDefault();

                if (aRadioIsChecked()) {
                    hideError();
                    form.submit();
                } else {
                    showError();
                }
            }
        })();
    </script>
@endsection
