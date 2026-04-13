<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::resource('patients', App\Http\Controllers\controllerPatient::class);
Route::resource('dossierMedical', App\Http\Controllers\controllerDossierMedical::class);
