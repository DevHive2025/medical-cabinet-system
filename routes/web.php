<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RendezVousController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('rendez-vous', RendezVousController::class);
Route::patch('/rendez-vous/{id}/annuler', [RendezVousController::class, 'annuler'])->name('rendez-vous.annuler');