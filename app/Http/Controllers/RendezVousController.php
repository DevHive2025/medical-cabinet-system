<?php
namespace App\Http\Controllers;

use App\Models\RendezVous;
use App\Models\Patient;
use App\Models\User; // Pour les médecins
use Illuminate\Http\Request;

class RendezVousController extends Controller
{
    // Affichage de la liste (Table simple)
    public function index()
    {
        $rdvs = RendezVous::with(['patient', 'medecin'])->orderBy('date_heure', 'asc')->get();
        return view('rendez_vous.index', compact('rdvs'));
    }

    // Formulaire de création
    public function create()
    {
        $patients = Patient::all();
        $medecins = User::where('role', 'medecin')->get(); // Supposant un champ role
        return view('rendez_vous.create', compact('patients', 'medecins'));
    }

    // Enregistrement du RDV
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medecin_id' => 'required|exists:users,id',
            'date_heure' => 'required|date|after:now',
            'motif' => 'nullable|string',
        ]);

        // Statut par défaut : 'en attente'
        RendezVous::create(array_merge($validated, ['statut' => 'en attente']));

        return redirect()->route('rendez-vous.index')->with('success', 'Rendez-vous créé avec succès.');
    }

    // Formulaire de modification
    public function edit($id)
    {
        $rdv = RendezVous::findOrFail($id);
        $patients = Patient::all();
        $medecins = User::where('role', 'medecin')->get();
        return view('rendez_vous.edit', compact('rdv', 'patients', 'medecins'));
    }

    // Mise à jour (Modification)
    public function update(Request $request, $id)
    {
        $rdv = RendezVous::findOrFail($id);
        $validated = $request->validate([
            'date_heure' => 'required|date',
            'statut' => 'required|in:en attente,confirmé,annulé',
            'motif' => 'nullable|string',
        ]);

        $rdv->update($validated);

        return redirect()->route('rendez-vous.index')->with('success', 'Rendez-vous mis à jour.');
    }

    // Annulation rapide
    public function annuler($id)
    {
        $rdv = RendezVous::findOrFail($id);
        $rdv->update(['statut' => 'annulé']);
        return back()->with('success', 'Le rendez-vous a été annulé.');
    }
}
