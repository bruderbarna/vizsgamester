<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Vizsgamester - @yield('title')</title>
        <link rel="stylesheet" type="text/css" href="/css/app.css" />
    </head>
    <body>
        @if (Auth::check())
            <header>
                <a href="{{ route('logout') }}">Kijelentkezés</a>
            </header>
        @endif
        <div class="container">
            @if (Session::has('warning-alerts'))
                @foreach (Session::get('warning-alerts') as $warning)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ $warning }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endforeach
            @endif
            @if ($errors->any())
                <p>Az alábbi hibák történtek:</p>

                <ul>
                    @foreach( $errors->all() as $message )
                    <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
            @yield('content')
        </div>
        <script src="/js/app.js"></script>
    </body>
</html>
