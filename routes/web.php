<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('welcome');
});

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
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
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
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
