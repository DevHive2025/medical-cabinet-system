<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\SecretaireController;
use App\Http\Controllers\DossierMedicalController;
use App\Http\Controllers\OrdonnanceController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('landing');
})->name('home');

Route::middleware('auth')->get('/dashboard', function () {
    return match (auth()->user()->role) {
        'admin'      => redirect()->route('admin.dashboard'),
        'medecin'    => redirect()->route('medecin.dashboard'),
        'secretaire' => redirect()->route('secretaire.dashboard'),
        default      => redirect()->route('patient.dashboard'),
    };
})->name('dashboard');

// (Admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::get('/stats', [StatsController::class, 'index'])->name('stats');
});

//(Médecin)
    Route::middleware(['auth', 'role:medecin'])->prefix('medecin')->name('medecin.')->group(function () {
        Route::get('/calendrier',[RendezVousController::class, 'calendrier'])->name('calendrier');
    Route::get('/dashboard',             [MedecinController::class, 'dashboard'])->name('dashboard');
    Route::get('/rendezvous',            [MedecinController::class, 'mesRendezVous'])->name('rendezvous');
    Route::patch('/rendezvous/{id}/annuler',   [MedecinController::class, 'annulerRdv'])->name('rendezvous.annuler');
    Route::get('/rendezvous/{id}/consultation', [MedecinController::class, 'createConsultation'])->name('consultation.create');
    Route::post('/rendezvous/{id}/consultation', [MedecinController::class, 'storeConsultation'])->name('consultation.store');
    Route::get('/patients',              [MedecinController::class, 'mesPatients'])->name('patients');
    Route::get('/consultations',         [MedecinController::class, 'mesConsultations'])->name('consultations');
    Route::get('/patients/{id}/dossier', [MedecinController::class, 'voirDossier'])->name('dossier');
    Route::get('/profil',                [MedecinController::class, 'profil'])->name('profil');
    Route::put('/profil',                [MedecinController::class, 'updateProfil'])->name('profil.update');
});

// (Secrétaire)
Route::middleware(['auth', 'role:secretaire'])->prefix('secretaire')->name('secretaire.')->group(function () {
    Route::get('/dashboard',   [SecretaireController::class, 'dashboard'])->name('dashboard');
    Route::get('/patients',    [SecretaireController::class, 'patients'])->name('patients');
    Route::get('/rendezvous',  [SecretaireController::class, 'rendezvous'])->name('rendezvous');
    Route::get('/medecins',    [SecretaireController::class, 'medecins'])->name('medecins');
});

// (Patient)
Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard',     [PatientController::class, 'dashboard'])->name('dashboard');
    Route::get('/consultations', [PatientController::class, 'consultations'])->name('consultations');
    Route::get('/rendezvous',    [PatientController::class, 'rendezvous'])->name('rendezvous');
    Route::get('/dossier',       [PatientController::class, 'dossier'])->name('dossier');
    Route::get('/ordonnances',   [PatientController::class, 'ordonnances'])->name('ordonnances');
    Route::get('/profil',        [PatientController::class, 'profil'])->name('profil');
    Route::put('/profil',        [PatientController::class, 'updateProfil'])->name('profil.update');
});


Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rendez-vous
    Route::get('/rendez-vous/confirmer/{id}', [App\Http\Controllers\RendezVousController::class, 'confirmerParEmail'])
    ->name('rendez-vous.confirmer');
    Route::patch('/rendez-vous/{id}/Sconfirmer', [RendezVousController::class, 'confirmer'])->name('rendez-vous.Sconfirmer');
    Route::patch('/rendez-vous/{id}/annuler', [RendezVousController::class, 'annuler'])->name('rendez-vous.annuler');
    Route::get('/rendez-vous/calendrier', [RendezVousController::class, 'calendrier'])->name('rendez-vous.calendrier');
    Route::get('/api/medecins-par-specialite', [RendezVousController::class, 'getMedecinsParSpecialite'])->name('api.medecins');
    Route::get('/api/creneaux-disponibles', [RendezVousController::class, 'getCreneauxDisponibles'])->name('api.creneaux');
    Route::resource('rendez-vous', RendezVousController::class);
    // Médical
    Route::resource('patients', PatientController::class);
    Route::resource('dossierMedical', DossierMedicalController::class);
    Route::resource('consultation',   ConsultationController::class);
    
    // Consultations & Ordonnances
    Route::get('/consultation/{id}/historique', [ConsultationController::class, 'historique'])->name('consultation.historique');
    Route::get('/consultation/{id}/pdf',        [ConsultationController::class, 'telechargerPDF'])->name('consultation.pdf');
    Route::get('/ordonnance/{consultationId}/create',  [OrdonnanceController::class, 'create'])->name('ordonnance.create');
    Route::post('/ordonnance/{consultationId}/store',   [OrdonnanceController::class, 'store'])->name('ordonnance.store');
    Route::get('/ordonnance/{id}',                      [OrdonnanceController::class, 'show'])->name('ordonnance.show');
    Route::get('/ordonnance/{id}/edit',                 [OrdonnanceController::class, 'edit'])->name('ordonnance.edit');
    Route::put('/ordonnance/{id}',                      [OrdonnanceController::class, 'update'])->name('ordonnance.update');
    Route::delete('/ordonnance/{id}',                   [OrdonnanceController::class, 'destroy'])->name('ordonnance.destroy');
    Route::get('/ordonnance/{id}/telecharger',          [OrdonnanceController::class, 'telecharger'])->name('ordonnance.telecharger');
});

require __DIR__.'/auth.php';