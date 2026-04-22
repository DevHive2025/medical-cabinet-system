<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use App\Models\Patient;
use App\Models\User; 
use App\Models\Medecin;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Mail\ConfirmationRdvMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class RendezVousController extends Controller
{
    /**
     * Affiche la liste des rendez-vous selon le rôle de l'utilisateur.
     */
    public function index()
    {
        $user = auth()->user();
        $query = RendezVous::with(['medecin.user', 'patient.user']);

        // Filtrage selon le rôle
        if ($user->role === 'patient') {
            $patient = Patient::where('user_id', $user->id)->first();
            $query = $patient ? $query->where('patient_id', $patient->id) : $query->where('id', 0);
        } 
        elseif ($user->role === 'secretaire') {
            // La secrétaire voit les rendez-vous du jour
            $query->whereDate('date_heure', Carbon::today());
        }

        $rdvs = $query->orderBy('date_heure', 'asc')->get();
        return view('rendez_vous.index', compact('rdvs'));
    }

    /**
     * Formulaire de création de rendez-vous.
     */
    public function create()
    {
        $specialites = Medecin::whereNotNull('specialite')->distinct()->pluck('specialite');
        $medecins = Medecin::with('user')->get();
        
        $patients = [];
        if (auth()->user()->role === 'secretaire') {
            $patients = Patient::with('user')->get();
        }

        return view('rendez_vous.create', compact('specialites', 'patients', 'medecins'));
    }

    /**
     * API : Récupère les médecins par spécialité.
     */
    public function getMedecinsParSpecialite(Request $request)
    {
        $medecins = Medecin::with('user')
            ->where('specialite', $request->specialite)
            ->get();
        
        $resultat = $medecins->map(function($medecin) {
            return [
                'id' => $medecin->id,
                'nom' => $medecin->user->nom ?? 'Inconnu',
                'prenom' => $medecin->user->prenom ?? ''
            ];
        });
                        
        return response()->json($resultat);
    }

    /**
     * API : Récupère les créneaux horaires disponibles.
     */
    public function getCreneauxDisponibles(Request $request)
    {
        $date = $request->date;
        $medecinId = $request->medecin_id;
        $excludeRdvId = $request->exclude_rdv_id;

        $query = RendezVous::where('medecin_id', $medecinId)
            ->whereDate('date_heure', $date)
            ->whereIn('statut', ['confirme', 'en_attente']);

        if ($excludeRdvId) {
            $query->where('id', '!=', $excludeRdvId);
        }

        $rdvsOccupes = $query->pluck('date_heure')
            ->map(function ($dt) { return Carbon::parse($dt)->format('H:i'); })
            ->toArray();

        $creneaux = [];
        for ($i = 8; $i <= 18; $i++) {
            $heure = sprintf('%02d:00', $i);
            $creneaux[] = [
                'heure' => $heure,
                'disponible' => !in_array($heure, $rdvsOccupes)
            ];
        }

        return response()->json($creneaux);
    }

    /**
     * Enregistre un nouveau rendez-vous et envoie un mail de confirmation.
     */
    public function store(Request $request)
    {
        $rules = [
            'medecin_id' => 'required|exists:medecins,id',
            'date_heure' => 'required|date|after:now',
            'motif'      => 'required|string'
        ];

        if (auth()->user()->role === 'secretaire') {
            $rules['patient_id'] = 'required|exists:patients,id';
        }

        $request->validate($rules);

        if (auth()->user()->role === 'secretaire') {
            $patientId = $request->patient_id;
        } else {
            $patient = Patient::where('user_id', auth()->id())->first();
            if (!$patient) return redirect()->back()->withErrors(['error' => 'Profil patient introuvable.']);
            $patientId = $patient->id;
        }

        $rdv = RendezVous::create([
            'patient_id' => $patientId,
            'medecin_id' => $request->medecin_id,
            'date_heure' => $request->date_heure,
            'motif'      => $request->motif,
            'statut'     => 'en_attente'
        ]);

        // Génération du lien de confirmation sécurisé
        $urlConfirmation = URL::temporarySignedRoute(
            'rendez-vous.confirmer', now()->addHours(24), ['id' => $rdv->id]
        );

        $rdv->load('patient.user');
        Mail::to($rdv->patient->user->email)->send(new ConfirmationRdvMail($rdv, $urlConfirmation));

        return redirect()->route('rendez-vous.index')->with('success', 'Rendez-vous créé ! Un email a été envoyé au patient.');
    }

    /**
     * Confirmation via le lien reçu par email.
     */
    public function confirmerParEmail(Request $request, $id)
    {
        $rdv = RendezVous::findOrFail($id);

        if ($rdv->statut !== 'en_attente') {
            return redirect()->route('rendez-vous.index')->with('error', 'Ce rendez-vous est déjà traité.');
        }

        $rdv->update(['statut' => 'confirme']);

        return redirect()->route('rendez-vous.index')->with('success', 'Votre rendez-vous est maintenant confirmé.');
    }

    public function edit($id)
    {
        $rdv = RendezVous::with('medecin.user')->findOrFail($id);
        $specialites = Medecin::whereNotNull('specialite')->distinct()->pluck('specialite');
        $currentSpecialite = $rdv->medecin->specialite;
        $currentDate = Carbon::parse($rdv->date_heure)->format('Y-m-d');
        $currentTime = Carbon::parse($rdv->date_heure)->format('H:i');
        $medecins = Medecin::with('user')->where('specialite', $rdv->medecin->specialite)->get();

        return view('rendez_vous.edit', compact('rdv', 'specialites', 'currentDate', 'currentTime', 'currentSpecialite', 'medecins'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'medecin_id' => 'required|exists:medecins,id',
            'date_heure' => 'required|date',
            'statut'     => 'required|in:en_attente,confirme,annule,termine',
            'motif'      => 'nullable|string',
        ]);

        $rdv = RendezVous::findOrFail($id);
        $rdv->update($request->all());

        return redirect()->route('rendez-vous.index')->with('success', 'Rendez-vous modifié avec succès !');
    }

    public function annuler($id)
    {
        $rdv = RendezVous::findOrFail($id);
        $rdv->update(['statut' => 'annule']);
        return back()->with('success', 'Le rendez-vous a été annulé.');
    }

    public function confirmer($id)
    {
        $rdv = RendezVous::findOrFail($id);
        $rdv->update(['statut' => 'confirme']);
        return back()->with('success', 'Le rendez-vous a été confirmé.');
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'statut' => 'required|in:en_attente,confirme,annule,termine',
        ]);

        $rdv = RendezVous::findOrFail($id);
        $rdv->update(['statut' => $validated['statut']]);

        return back()->with('success', 'Statut mis à jour.');
    }

    public function calendrier(Request $request)
    {
        $dateParam = $request->input('date', Carbon::today()->format('Y-m-d'));
        $selectedDate = Carbon::parse($dateParam);
        $medecinId = auth()->user()->medecin->id ?? null;

        if (!$medecinId) abort(403, 'Accès réservé aux médecins.');

        $rdvs = RendezVous::with(['patient.user'])
            ->where('medecin_id', $medecinId)
            ->whereDate('date_heure', $selectedDate)
            ->orderBy('date_heure', 'asc')
            ->get();

        $rdvsMois = RendezVous::whereMonth('date_heure', $selectedDate->month)
            ->whereYear('date_heure', $selectedDate->year)
            ->pluck('date_heure')
            ->map(fn($val) => Carbon::parse($val)->format('Y-m-d'))
            ->unique()
            ->toArray();

        return view('rendez_vous.calendrier', compact('rdvs', 'selectedDate', 'rdvsMois'));
    }
}