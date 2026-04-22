<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\DashboardController;
Route::get('/', function () {

    return auth()->check()
        ? redirect()->route('dashboard')
        : view('welcome');
});
Route::get('/home', function () {

    return view('landing');
})->name('home');
Route::middleware('auth')->get('/dashboard', function () {
    $user = auth()->user();

    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'medecin' => redirect()->route('medecin.dashboard'),
        'secretaire' => redirect()->route('secretaire.dashboard'),
        default => redirect()->route('patient.dashboard'),
    };
})->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('users', UserController::class);
    Route::get('/stats', [StatsController::class, 'index'])->name('admin.stats');
    
});

Route::middleware(['auth', 'role:medecin'])->prefix('medecin')->group(function () {
    Route::get('/dashboard', function () {
        return view('medecin.dashboard');
    })->name('medecin.dashboard');
    
});

Route::middleware(['auth', 'role:secretaire'])->prefix('secretaire')->group(function () {
    Route::get('/dashboard', function () {
        return view('secretaire.dashboard');
    })->name('secretaire.dashboard');
});

Route::middleware(['auth', 'role:patient'])->prefix('patient')->group(function () {
    Route::get('/dashboard', function () {
        return view('patient.dashboard');
    })->name('patient.dashboard');
    Route::resource('rendez-vous', RendezVousController::class);
});
Route::get('/rendez-vous/confirmer/{id}', [App\Http\Controllers\RendezVousController::class, 'confirmerParEmail'])
    ->name('rendez-vous.confirmer');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/rendez-vous/{id}/Sconfirmer', [RendezVousController::class, 'confirmer'])->name('rendez-vous.Sconfirmer');
    Route::patch('/rendez-vous/{id}/annuler', [RendezVousController::class, 'annuler'])->name('rendez-vous.annuler');
    Route::get('/rendez-vous/calendrier', [RendezVousController::class, 'calendrier'])->name('rendez-vous.calendrier');
    Route::get('/api/medecins-par-specialite', [RendezVousController::class, 'getMedecinsParSpecialite'])->name('api.medecins');
    Route::get('/api/creneaux-disponibles', [RendezVousController::class, 'getCreneauxDisponibles'])->name('api.creneaux');
    
    Route::resource('patients', App\Http\Controllers\controllerPatient::class);
    Route::resource('dossierMedical', App\Http\Controllers\DossierMedicalController::class);

});

require __DIR__.'/auth.php';




