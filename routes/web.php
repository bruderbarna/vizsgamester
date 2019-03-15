<?php

Route::get('/', function () { return view('home'); })->name('home');

Route::get('/previzsga/{vizsgakod}', 'VizsgaController@preVizsga')->name('previzsga');

Route::post('/startvizsga', 'VizsgaController@startVizsga');

Route::get('/vizsga/{vizsgazasId}/kerdes/{kerdesszam}', 'VizsgaController@showKerdes')->name('showKerdes');

Route::post('/valasz', 'VizsgaController@valasz');

Route::get('/vizsgaOsszegzes/{vizsgazasId}', 'VizsgaController@vizsgaOsszegzes')->name('vizsgaOsszegzes');

Route::get('/error', function () { return view('generic-error'); })->name('error');

Route::get(
    '/recoverable-kerdes-error/{vizsgazasId}/{kerdesszam}',
    function ($vizsgazasId, $kerdesszam)
    {
        return view('recoverable-kerdes-error', [
            'kerdesszam' => $kerdesszam,
            'vizsgazasId' => $vizsgazasId
        ]);
    }
)->name('recoverableKerdesError');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');

Route::post('login', 'Auth\LoginController@login')->name('loginPost');

Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('dashboard', 'DashboardController@show')->name('dashboard');

    Route::get('vizsga-reszletek/{vizsgaId}', 'DashboardController@vizsgaReszletek')->name('vizsgaReszletek');
});
