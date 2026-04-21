<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ConsultationController extends Controller
{
    // Liste des consultations
    public function index()
    {
        $consultations = Consultation::with('rendezVous.patient.user', 'rendezVous.medecin.user')
            ->latest()
            ->get();
        return view('consultation.index', compact('consultations'));
    }

    // Historique des consultations par patient
    public function historique($patientId)
    {
        $consultations = Consultation::whereHas('rendezVous', function($q) use ($patientId) {
            $q->where('patient_id', $patientId);
        })->with('rendezVous.medecin.user', 'ordonnances')->latest()->get();

        return view('consultation.historique', compact('consultations'));
    }

    // Formulaire saisie compte-rendu
    public function create()
    {
        return view('consultation.create');
    }

    // Enregistrer compte-rendu
    public function store(Request $request)
    {
        $request->validate([
            'rendez_vous_id' => 'required|exists:rendez_vous,id|unique:consultations,rendez_vous_id',
            'date'           => 'required|date',
            'symptomes'      => 'required|string',
            'diagnostic'     => 'required|string',
            'compte_rendu'   => 'required|string',
        ]);

        $consultation = Consultation::create([
            'rendez_vous_id' => $request->rendez_vous_id,
            'date'           => $request->date,
            'symptomes'      => $request->symptomes,
            'diagnostic'     => $request->diagnostic,
            'compte_rendu'   => $request->compte_rendu,
        ]);

        return redirect()->route('consultation.show', $consultation->id)
            ->with('success', 'Consultation créée avec succès.');
    }

    // Détails d'une consultation
    public function show($id)
    {
        $consultation = Consultation::with(
            'rendezVous.patient.user',
            'rendezVous.medecin.user',
            'ordonnances.lignes'
        )->findOrFail($id);

        return view('consultation.show', compact('consultation'));
    }

    // Formulaire modification compte-rendu
    public function edit($id)
    {
        $consultation = Consultation::findOrFail($id);
        return view('consultation.edit', compact('consultation'));
    }

    // Mettre à jour compte-rendu
    public function update(Request $request, $id)
    {
        $request->validate([
            'date'         => 'required|date',
            'symptomes'    => 'required|string',
            'diagnostic'   => 'required|string',
            'compte_rendu' => 'required|string',
        ]);

        Consultation::findOrFail($id)->update([
            'date'         => $request->date,
            'symptomes'    => $request->symptomes,
            'diagnostic'   => $request->diagnostic,
            'compte_rendu' => $request->compte_rendu,
        ]);

        return redirect()->route('consultation.index')->with('success', 'Consultation mise à jour.');
    }

    // Supprimer
    public function destroy($id)
    {
        Consultation::findOrFail($id)->delete();
        return redirect()->route('consultation.index')->with('success', 'Consultation supprimée.');
    }

    // Générer et télécharger PDF
    public function telechargerPDF($id)
    {
        $consultation = Consultation::with(
            'rendezVous.patient.user',
            'rendezVous.medecin.user',
            'ordonnances.lignes'
        )->findOrFail($id);

        $pdf = Pdf::loadView('consultation.pdf', compact('consultation'));
        return $pdf->download('consultation-'.$consultation->id.'.pdf');
    }
}
