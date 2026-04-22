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
    // Affichage de la liste (Table simple)
    public function index()
    {
    $user = auth()->user();
    
    // On commence par une requête de base avec les relations pour éviter les bugs d'affichage
    $query = RendezVous::with(['medecin.user', 'patient.user']);

    // CAS 1 : Si l'utilisateur est un PATIENT
    if ($user->role === 'patient') {
        // On récupère son profil patient
        $patient = Patient::where('user_id', $user->id)->first();
        
        if ($patient) {
            // Il ne voit QUE ses propres rendez-vous
            $query->where('patient_id', $patient->id);
        } else {
            // Sécurité : s'il n'a pas de profil, il ne voit rien
            $query->where('id', 0);
        }
    } 
    // CAS 2 : Si l'utilisateur est une SECRÉTAIRE
    elseif ($user->role === 'secretaire') { // Vérifiez que le nom du rôle est bien 'secretaire'
        // Elle voit TOUS les patients, mais seulement pour AUJOURD'HUI
        $query->whereDate('date_heure', Carbon::today());
    }
    
    // On récupère les résultats triés par date
    $rdvs = $query->orderBy('date_heure', 'asc')->get();

    return view('rendez_vous.index', compact('rdvs'));
}

    // Formulaire de création
// 1. Fonction create corrigée :
    public function create()
    {
        $specialites = Medecin::whereNotNull('specialite')->distinct()->pluck('specialite');
        
        $patients = [];
        // Si c'est la secrétaire, on récupère la liste de tous les patients
        if (auth()->user()->role === 'secretaire') {
            $patients = Patient::with('user')->get();
        }

        return view('rendez_vous.create', compact('specialites', 'patients'));
    }

    // 2. Fonction getMedecinsParSpecialite corrigée :
    public function getMedecinsParSpecialite(Request $request)
    {
        // On récupère les médecins avec cette spécialité
        // et on charge la relation 'user' pour avoir accès au nom/prénom
        $medecins = Medecin::with('user')
                        ->where('specialite', $request->specialite)
                        ->get();
        
        // On formate la réponse pour qu'elle soit facilement lisible par notre Javascript
        $resultat = $medecins->map(function($medecin) {
            return [
                'id' => $medecin->id, // L'ID qui sera envoyé lors de la création du RDV
                'nom' => $medecin->user->nom ?? 'Inconnu',
                'prenom' => $medecin->user->prenom ?? ''
            ];
        });
                        
        return response()->json($resultat);
    }

// 3. Ajouter cette fonction pour récupérer les créneaux d'un jour précis :
    public function getCreneauxDisponibles(Request $request)
    {
        $date = $request->date;
        $medecinId = $request->medecin_id;
        $excludeRdvId = $request->exclude_rdv_id; // <-- Nouveau paramètre

        $query = RendezVous::where('medecin_id', $medecinId)
            ->whereDate('date_heure', $date)
            ->whereIn('statut', ['confirme', 'en_attente']);

        // Si on modifie, on ne compte pas l'heure du RDV actuel comme "occupée"
        if ($excludeRdvId) {
            $query->where('id', '!=', $excludeRdvId);
        }

        $rdvs = $query->pluck('date_heure')
            ->map(function ($dt) { return Carbon::parse($dt)->format('H:i'); })
            ->toArray();

        $creneaux = [];
        for ($i = 8; $i <= 19; $i++) {
            $heure = sprintf('%02d:00', $i);
            $creneaux[] = [
                'heure' => $heure,
                'disponible' => !in_array($heure, $rdvs)
            ];
        }

        return response()->json($creneaux);
    }

    // Enregistrement du RDV
    // 1. Modifier la fonction store
    // 2. La fonction STORE
    public function store(Request $request)
    {
        // On prépare les règles de validation de base
        $rules = [
            'medecin_id' => 'required|exists:medecins,id',
            'date_heure' => 'required|date',
            'motif'      => 'required|string'
        ];

        // Si c'est la secrétaire, on exige qu'elle sélectionne un patient
        if (auth()->user()->role === 'secretaire') {
            $rules['patient_id'] = 'required|exists:patients,id';
        }

        $request->validate($rules);

        // Déterminer QUI est le patient
        if (auth()->user()->role === 'secretaire') {
            $patientId = $request->patient_id;
        } else {
            // Si c'est un patient connecté, on cherche son propre ID
            $patient = Patient::where('user_id', auth()->id())->first();
            if (!$patient) {
                return redirect()->back()->withErrors(['error' => 'Erreur : Aucun profil patient.']);
            }
            $patientId = $patient->id;
        }

        // Création du rendez-vous
        $rdv = RendezVous::create([
            'patient_id' => $patientId,
            'medecin_id' => $request->medecin_id,
            'date_heure' => $request->date_heure,
            'motif'      => $request->motif,
            'statut'     => 'en_attente'
        ]);

        // Générer le lien de confirmation
        $urlConfirmation = URL::temporarySignedRoute(
            'rendez-vous.confirmer', now()->addHours(24), ['id' => $rdv->id]
        );

        // ATTENTION ICI : On doit envoyer l'email au PATIENT, pas à la personne connectée !
        // On charge la relation patient->user pour avoir la bonne adresse email
        $rdv->load('patient.user');
        $emailDestinataire = $rdv->patient->user->email;

        Mail::to($emailDestinataire)->send(new ConfirmationRdvMail($rdv, $urlConfirmation));

        return redirect()->route('rendez-vous.index')->with('success', 'Le rendez-vous a été créé avec succès ! Un email de confirmation a été envoyé au patient.');
    }

    // 2. Ajouter la fonction de confirmation (Celle déclenchée par le clic dans l'email)
    public function confirmerParEmail(Request $request, $id)
    {
        $rdv = RendezVous::findOrFail($id);

        // Optionnel : vérifier si le rdv n'est pas déjà confirmé ou annulé
        if ($rdv->statut !== 'en_attente') {
            return redirect()->route('rendez-vous.index')->with('error', 'Ce rendez-vous a déjà été traité.');
        }

        // On change le statut !
        $rdv->update([
            'statut' => 'confirme'
        ]);

        return redirect()->route('rendez-vous.index')->with('success', 'Génial ! Votre rendez-vous est maintenant confirmé.');
    }

    // Formulaire de modification
    public function edit($id)
    {
        $rdv = RendezVous::with('medecin.user')->findOrFail($id);
        
        // Sécurité : vérifier que le patient connecté est bien le propriétaire
        $patient = Patient::where('user_id', auth()->id())->first();
        // $secritaire = Secretaire::where('user_id', auth()->id())->first();
        // if (!$patient || $rdv->patient_id !== $patient->id) {
        //     if (!$secritaire) {
        //     abort(403, 'Accès non autorisé');
        // }
        // }
        

        $specialites = Medecin::whereNotNull('specialite')->distinct()->pluck('specialite');
        
        // Données actuelles pour pré-remplir le formulaire
        $currentDate = Carbon::parse($rdv->date_heure)->format('Y-m-d');
        $currentTime = Carbon::parse($rdv->date_heure)->format('H:i');
        $currentSpecialite = $rdv->medecin->specialite;
        
        // Liste des médecins de la spécialité actuelle
        $medecins = Medecin::with('user')->where('specialite', $currentSpecialite)->get();

        return view('rendez_vous.edit', compact('rdv', 'specialites', 'currentDate', 'currentTime', 'currentSpecialite', 'medecins'));
    }

    // 3. Ajouter la fonction Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'medecin_id' => 'required|exists:medecins,id',
            'date_heure' => 'required|date',
            'motif'      => 'nullable|string'
        ]);

        $rdv = RendezVous::findOrFail($id);
        
        $rdv->update([
            'medecin_id' => $request->medecin_id,
            'date_heure' => $request->date_heure,
            'motif'      => $request->motif,
        ]);

        return redirect()->route('rendez-vous.index')->with('success', 'Rendez-vous modifié avec succès !');
    }
 
    // Annulation rapide
    public function annuler($id)
    {
        $rdv = RendezVous::findOrFail($id);
        $rdv->update(['statut' => 'annule']);
        return back()->with('success', 'Le rendez-vous a été annulé.');
    }
    public function calendrier(Request $request)
    {
        // 1. Définir la date sélectionnée (aujourd'hui par défaut)
        $dateParam = $request->input('date', Carbon::today()->format('Y-m-d'));
        $selectedDate = Carbon::parse($dateParam);
        $medecinId = auth()->user()->medecin->id ?? null;

        if (!$medecinId) {
            abort(403, 'Accès non autorisé');
        }

        // 2. Récupérer les rendez-vous du jour sélectionné
        $rdvs = RendezVous::with(['patient', 'medecin'])
            ->where('medecin_id', $medecinId)
            ->whereDate('date_heure', $selectedDate)
            ->orderBy('date_heure', 'asc')
            ->get();

        // 3. Récupérer les jours du mois qui ont des rendez-vous (pour les points verts)
        $rdvsMois = RendezVous::whereMonth('date_heure', $selectedDate->month)
            ->whereYear('date_heure', $selectedDate->year)
            ->get()
            ->groupBy(function($val) {
                return Carbon::parse($val->date_heure)->format('Y-m-d');
            })->keys()->toArray();

        return view('rendez_vous.calendrier', compact('rdvs', 'selectedDate', 'rdvsMois'));
    }
    public function confirmer($id)
    {
        $rdv = RendezVous::findOrFail($id);

        $rdv->update(['statut' => 'confirme']);
        return back()->with('success', 'Le rendez-vous a été confirmé.');
    }
}
