<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use App\Models\Patient;
use App\Models\DossierMedical;
use App\Models\Consultation;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MedecinController extends Controller
{
    private function getMedecin()
    {
        return Medecin::where('user_id', auth()->id())->firstOrFail();
    }

    public function dashboard()
    {
        $medecin = $this->getMedecin();

        $totalRendezVous    = RendezVous::where('medecin_id', $medecin->id)->count();
        $totalPatients      = RendezVous::where('medecin_id', $medecin->id)->distinct('patient_id')->count();
        $totalConsultations = Consultation::whereHas('rendezVous', fn($q) => $q->where('medecin_id', $medecin->id))->count();
        $rdvAujourdhui      = RendezVous::where('medecin_id', $medecin->id)->whereDate('date_heure', today())->count();

        $prochainRdv = RendezVous::with('patient.user')
            ->where('medecin_id', $medecin->id)
            ->where('date_heure', '>=', now())
            ->whereIn('statut', ['en_attente', 'confirme'])
            ->orderBy('date_heure')
            ->take(5)
            ->get();

        $dernieresConsultations = Consultation::with('rendezVous.patient.user')
            ->whereHas('rendezVous', fn($q) => $q->where('medecin_id', $medecin->id))
            ->latest()
            ->take(5)
            ->get();

        $rdvEnAttente = RendezVous::with('patient.user')
            ->where('medecin_id', $medecin->id)
            ->where('statut', 'en_attente')
            ->orderBy('date_heure')
            ->get();

        return view('medecin.dashboard', compact(
            'totalRendezVous', 'totalPatients', 'totalConsultations',
            'rdvAujourdhui', 'prochainRdv', 'dernieresConsultations', 'rdvEnAttente'
        ));
    }

    public function mesRendezVous()
    {
        $medecin    = $this->getMedecin();
        $rendezVous = RendezVous::with('patient.user', 'consultation')
            ->where('medecin_id', $medecin->id)
            ->orderBy('date_heure', 'desc')
            ->get();

        return view('medecin.rendezvous', compact('rendezVous'));
    }

    public function annulerRdv($id)
    {
        $medecin = $this->getMedecin();
        RendezVous::where('id', $id)->where('medecin_id', $medecin->id)->firstOrFail()
            ->update(['statut' => 'annule']);
        return back()->with('success', 'Rendez-vous annulé.');
    }

    public function createConsultation($rdvId)
    {
        $medecin    = $this->getMedecin();
        $rendezVous = RendezVous::with('patient.user')
            ->where('id', $rdvId)
            ->where('medecin_id', $medecin->id)
            ->firstOrFail();
        return view('medecin.createConsultation', compact('rendezVous'));
    }

    public function storeConsultation(Request $request, $rdvId)
    {
        $medecin    = $this->getMedecin();
        $rendezVous = RendezVous::where('id', $rdvId)->where('medecin_id', $medecin->id)->firstOrFail();

        $request->validate([
            'date'         => 'required|date',
            'symptomes'    => 'required|string',
            'diagnostic'   => 'required|string',
            'compte_rendu' => 'required|string',
        ]);

        Consultation::create([
            'rendez_vous_id' => $rdvId,
            'date'           => $request->date,
            'symptomes'      => $request->symptomes,
            'diagnostic'     => $request->diagnostic,
            'compte_rendu'   => $request->compte_rendu,
        ]);

        $rendezVous->update(['statut' => 'termine']);

        return redirect()->route('medecin.consultations')->with('success', 'Consultation enregistrée.');
    }

    public function mesPatients()
    {
        $medecin  = $this->getMedecin();
        $patients = Patient::with('user')
            ->whereHas('rendezVous', fn($q) => $q->where('medecin_id', $medecin->id))
            ->get();

        return view('medecin.patients', compact('patients'));
    }

    public function voirDossier($id)
    {
        $medecin        = $this->getMedecin();
        $dossierMedical = DossierMedical::with('patient.user')
            ->whereHas('patient.rendezVous', fn($q) => $q->where('medecin_id', $medecin->id))
            ->findOrFail($id);

        return view('medecin.dossier', compact('dossierMedical'));
    }

    public function mesConsultations()
    {
        $medecin       = $this->getMedecin();
        $consultations = Consultation::with('rendezVous.patient.user')
            ->whereHas('rendezVous', fn($q) => $q->where('medecin_id', $medecin->id))
            ->latest()
            ->get();

        return view('medecin.consultations', compact('consultations'));
    }

    public function profil()
    {
        $medecin = $this->getMedecin();
        return view('medecin.profil', compact('medecin'));
    }

    public function updateProfil(Request $request)
    {
        $medecin = $this->getMedecin();

        $request->validate([
            'nom'      => 'required|string',
            'prenom'   => 'required|string',
            'email'    => 'required|email|unique:users,email,' . $medecin->user_id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $medecin->user->update([
            'nom'    => $request->nom,
            'prenom' => $request->prenom,
            'email'  => $request->email,
        ]);

        if ($request->filled('password')) {
            $medecin->user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('medecin.profil')->with('success', 'Profil mis à jour.');
    }
}
