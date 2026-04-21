<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\DossierMedicalController;
use App\Http\Controllers\controllerPatient;

// Page d'accueil
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('welcome');
});

// Redirection selon le rôle
Route::middleware('auth')->get('/dashboard', function () {
    return match (auth()->user()->role) {
        'admin'      => redirect()->route('admin.dashboard'),
        'medecin'    => redirect()->route('medecin.dashboard'),
        'secretaire' => redirect()->route('secretaire.dashboard'),
        default      => redirect()->route('patient.dashboard'),
    };
})->name('dashboard');

// =====================
// Espace Admin
// =====================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

// =====================
// Espace Médecin
// =====================
Route::middleware(['auth', 'role:medecin'])->prefix('medecin')->name('medecin.')->group(function () {
    Route::get('/dashboard',             [MedecinController::class, 'dashboard'])->name('dashboard');
    Route::get('/rendezvous',                  [MedecinController::class, 'mesRendezVous'])->name('rendezvous');
    Route::patch('/rendezvous/{id}/annuler',   [MedecinController::class, 'annulerRdv'])->name('rendezvous.annuler');
    Route::get('/rendezvous/{id}/consultation',     [MedecinController::class, 'createConsultation'])->name('consultation.create');
    Route::post('/rendezvous/{id}/consultation',    [MedecinController::class, 'storeConsultation'])->name('consultation.store');
    Route::get('/patients',              [MedecinController::class, 'mesPatients'])->name('patients');
    Route::get('/consultations',         [MedecinController::class, 'mesConsultations'])->name('consultations');
    Route::get('/patients/{id}/dossier', [MedecinController::class, 'voirDossier'])->name('dossier');
    Route::get('/profil',                [MedecinController::class, 'profil'])->name('profil');
    Route::put('/profil',                [MedecinController::class, 'updateProfil'])->name('profil.update');
});

// =====================
// Espace Secrétaire
// =====================
Route::middleware(['auth', 'role:secretaire'])->prefix('secretaire')->name('secretaire.')->group(function () {
    Route::get('/dashboard',   [App\Http\Controllers\SecretaireController::class, 'dashboard'])->name('dashboard');
    Route::get('/patients',    [App\Http\Controllers\SecretaireController::class, 'patients'])->name('patients');
    Route::get('/rendezvous',  [App\Http\Controllers\SecretaireController::class, 'rendezvous'])->name('rendezvous');
    Route::get('/medecins',    [App\Http\Controllers\SecretaireController::class, 'medecins'])->name('medecins');
});

// =====================
// Espace Patient
// =====================
Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard',     [PatientController::class, 'dashboard'])->name('dashboard');
    Route::get('/consultations', [PatientController::class, 'consultations'])->name('consultations');
    Route::get('/rendezvous',    [PatientController::class, 'rendezvous'])->name('rendezvous');
    Route::get('/dossier',       [PatientController::class, 'dossier'])->name('dossier');
    Route::get('/ordonnances',   [PatientController::class, 'ordonnances'])->name('ordonnances');
    Route::get('/profil',        [PatientController::class, 'profil'])->name('profil');
    Route::put('/profil',        [PatientController::class, 'updateProfil'])->name('profil.update');
});

// =====================
// CRUD
// =====================
Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('rendez-vous',    RendezVousController::class);
    Route::patch('/rendez-vous/{id}/status', [RendezVousController::class, 'updateStatus'])->name('rendez-vous.status');
    Route::resource('patients', PatientController::class);
    Route::resource('dossierMedical', DossierMedicalController::class);
    Route::resource('consultation',   ConsultationController::class);
    Route::get('/consultation/{id}/historique',        [ConsultationController::class, 'historique'])->name('consultation.historique');
    Route::get('/consultation/{id}/pdf',               [ConsultationController::class, 'telechargerPDF'])->name('consultation.pdf');
    Route::get('/ordonnance/{consultationId}/create',  [App\Http\Controllers\OrdonnanceController::class, 'create'])->name('ordonnance.create');
    Route::post('/ordonnance/{consultationId}/store',  [App\Http\Controllers\OrdonnanceController::class, 'store'])->name('ordonnance.store');
    Route::get('/ordonnance/{id}',                     [App\Http\Controllers\OrdonnanceController::class, 'show'])->name('ordonnance.show');
    Route::get('/ordonnance/{id}/telecharger',         [App\Http\Controllers\OrdonnanceController::class, 'telecharger'])->name('ordonnance.telecharger');
});

require __DIR__.'/auth.php';
