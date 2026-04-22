<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Consultation;
use App\Models\Ordonnance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    // =====================
    // CRUD Admin/Secretaire
    // =====================
    public function index()
    {
        $patients = Patient::with('user')->get();
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'            => 'required',
            'prenom'         => 'required',
            'email'          => 'required|email|unique:users',
            'password'       => 'required|confirmed|min:6',
            'date_naissance' => 'required|date',
            'telephone'      => 'required',
        ]);

        $user = User::create([
            'nom'      => $request->nom,
            'prenom'   => $request->prenom,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'patient',
        ]);

        Patient::create([
            'user_id'        => $user->id,
            'date_naissance' => $request->date_naissance,
            'telephone'      => $request->telephone,
            'cin'            => $request->cin,
        ]);

        return redirect()->route('patients.index')->with('success', 'Patient créé.');
    }

    public function show($id)
    {
        $patient = Patient::with('user')->findOrFail($id);
        return view('patients.show', compact('patient'));
    }

    public function edit($id)
    {
        $patient = Patient::with('user')->findOrFail($id);
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $request->validate([
            'nom'    => 'required',
            'prenom' => 'required',
            'email'  => 'required|email|unique:users,email,' . $patient->user_id,
        ]);

        $patient->user->update([
            'nom'    => $request->nom,
            'prenom' => $request->prenom,
            'email'  => $request->email,
        ]);

        if ($request->filled('password')) {
            $patient->user->update(['password' => Hash::make($request->password)]);
        }

        $patient->update([
            'telephone'      => $request->telephone,
            'date_naissance' => $request->date_naissance,
        ]);

        return redirect()->route('patients.index')->with('success', 'Patient mis à jour.');
    }

    public function destroy($id)
    {
        Patient::findOrFail($id)->user->delete();
        return redirect()->route('patients.index')->with('success', 'Patient supprimé.');
    }

    // =====================
    // Espace Patient
    // =====================
    private function getPatient()
    {
        return Patient::where('user_id', auth()->id())->firstOrFail();
    }

    public function dashboard()
    {
        $patient = $this->getPatient();

        $consultations = Consultation::whereHas('rendezVous', function($q) use ($patient) {
            $q->where('patient_id', $patient->id)
              ->where('date_heure', '>=', now()->subYear());
        })->with('rendezVous.medecin.user')->get();

        $prochainRendezVous = $patient->rendezVous()
            ->where('date_heure', '>=', now())
            ->with('medecin.user')
            ->orderBy('date_heure')
            ->first();

        $rdvEnAttente = $patient->rendezVous()
            ->where('statut', 'en_attente')
            ->with('medecin.user')
            ->orderBy('date_heure')
            ->first();

        return view('patient.dashboard', compact('consultations', 'prochainRendezVous', 'rdvEnAttente'));
    }

    public function consultations()
    {
        $patient = $this->getPatient();

        $consultations = Consultation::whereHas('rendezVous', function($q) use ($patient) {
            $q->where('patient_id', $patient->id);
        })->with('rendezVous.medecin.user')->get();

        return view('patient.consultations', compact('consultations'));
    }

    public function rendezvous()
    {
        $patient    = $this->getPatient();
        $rendezVous = $patient->rendezVous()->with('medecin.user')->orderBy('date_heure', 'desc')->get();
        return view('patient.rendezvous', compact('rendezVous'));
    }

    public function dossier()
    {
        $patient = $this->getPatient();
        $patient->load('dossierMedical');
        return view('patient.dossier', compact('patient'));
    }

    public function ordonnances()
    {
        $patient = $this->getPatient();

        $ordonnances = Ordonnance::whereHas('consultation.rendezVous', function($q) use ($patient) {
            $q->where('patient_id', $patient->id);
        })->with(['consultation.rendezVous.medecin.user', 'lignes'])->get();

        return view('patient.ordonnances', compact('ordonnances'));
    }

    public function profil()
    {
        $patient = $this->getPatient();
        $patient->load('user');
        return view('patient.profil', compact('patient'));
    }

    public function updateProfil(Request $request)
    {
        $user    = auth()->user();
        $patient = $this->getPatient();

        $request->validate([
            'nom'            => 'required|string',
            'prenom'         => 'required|string',
            'email'          => 'required|email|unique:users,email,' . $user->id,
            'telephone'      => 'required|string',
            'date_naissance' => 'required|date',
            'password'       => 'nullable|min:6|confirmed',
        ]);

        $user->update([
            'nom'    => $request->nom,
            'prenom' => $request->prenom,
            'email'  => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        $patient->update([
            'telephone'      => $request->telephone,
            'date_naissance' => $request->date_naissance,
        ]);

        return redirect()->route('patient.profil')->with('success', 'Profil mis à jour avec succès.');
    }
}
