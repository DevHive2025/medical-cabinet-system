<?php
namespace App\Http\Controllers;

use App\Models\RendezVous;
use App\Models\Patient;
use App\Models\Medecin;
use Illuminate\Http\Request;

class RendezVousController extends Controller
{
    // Affichage de la liste (Table simple)
    public function index()
    {
        $rdvs = RendezVous::with(['patient.user', 'medecin.user'])->orderBy('date_heure', 'asc')->get();
        return view('rendez_vous.index', compact('rdvs'));
    }

    // Formulaire de création
    public function create()
    {
        $patients = Patient::with('user')->get();
        $medecins = Medecin::with('user')->get();
        return view('rendez_vous.create', compact('patients', 'medecins'));
    }

    // Enregistrement du RDV
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medecin_id' => 'required|exists:medecins,id',
            'date_heure' => 'required|date|after:now',
            'motif' => 'nullable|string',
        ]);

        // Statut par défaut : 'en attente'
        RendezVous::create(array_merge($validated, ['statut' => 'en_attente']));

        return redirect()->route('rendez-vous.index')->with('success', 'Rendez-vous créé avec succès.');
    }

    // Formulaire de modification
    public function edit($id)
    {
        $rdv = RendezVous::findOrFail($id);
        $patients = Patient::with('user')->get();
        $medecins = Medecin::with('user')->get();
        return view('rendez_vous.edit', compact('rdv', 'patients', 'medecins'));
    }

    // Mise à jour (Modification)
    public function update(Request $request, $id)
    {
        $rdv = RendezVous::findOrFail($id);
        $validated = $request->validate([
            'date_heure' => 'required|date',
            'statut' => 'required|in:en_attente,confirme,annule,termine',
            'motif' => 'nullable|string',
        ]);

        $rdv->update($validated);

        return redirect()->route('rendez-vous.index')->with('success', 'Rendez-vous mis à jour.');
    }
 
    // Annulation rapide
    public function annuler($id)
    {
        $rdv = RendezVous::findOrFail($id);
        $rdv->update(['statut' => 'annule']);
        return back()->with('success', 'Le rendez-vous a été annulé.');
    }

    // Changement rapide du statut depuis la liste
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'statut' => 'required|in:en_attente,confirme,annule,termine',
        ]);

        $rdv = RendezVous::findOrFail($id);
        $rdv->update(['statut' => $validated['statut']]);

        return back()->with('success', 'Statut du rendez-vous mis à jour.');
    }
}
