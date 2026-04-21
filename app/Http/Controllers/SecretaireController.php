<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Medecin;
use App\Models\RendezVous;
use App\Models\Consultation;
use Illuminate\Http\Request;

class SecretaireController extends Controller
{
    public function dashboard()
    {
        $totalPatients      = Patient::count();
        $totalMedecins      = Medecin::count();
        $totalRendezVous    = RendezVous::count();
        $totalConsultations = Consultation::count();

        $derniersRdv = RendezVous::with('patient.user', 'medecin.user')
            ->latest()
            ->take(5)
            ->get();

        $rdvEnAttente = RendezVous::with('patient.user', 'medecin.user')
            ->where('statut', 'en_attente')
            ->orderBy('date_heure')
            ->get();

        return view('secretaire.dashboard', compact(
            'totalPatients', 'totalMedecins',
            'totalRendezVous', 'totalConsultations',
            'derniersRdv', 'rdvEnAttente'
        ));
    }

    public function patients()
    {
        $patients = Patient::with('user')->get();
        return view('secretaire.patients', compact('patients'));
    }

    public function rendezvous()
    {
        $rendezVous = RendezVous::with('patient.user', 'medecin.user')
            ->orderBy('date_heure', 'desc')
            ->get();
        $patients = Patient::with('user')->get();
        $medecins = Medecin::with('user')->get();

        return view('secretaire.rendezvous', compact('rendezVous', 'patients', 'medecins'));
    }

    public function medecins()
    {
        $medecins = Medecin::with('user')->get();
        return view('secretaire.medecins', compact('medecins'));
    }
}
