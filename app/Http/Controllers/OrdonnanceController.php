<?php

namespace App\Http\Controllers;

use App\Models\Ordonnance;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdonnanceController extends Controller
{
    // Formulaire création ordonnance
    public function create($consultationId)
    {
        $consultation = Consultation::with('rendezVous.patient.user')->findOrFail($consultationId);
        return view('ordonnance.create', compact('consultation'));
    }

    // Enregistrer ordonnance
    public function store(Request $request, $consultationId)
    {
        $request->validate([
            'date_ordonnance' => 'required|date',
            'lignes'          => 'required|array|min:1',
            'lignes.*.medicament'   => 'required|string',
            'lignes.*.dose'       => 'nullable|string',
            'lignes.*.psologie'      => 'nullable|string',
            'lignes.*.duree'        => 'nullable|string',
            'lignes.*.instructions' => 'nullable|string',
        
        ]);

        $ordonnance = Ordonnance::create([
            'consultation_id' => $consultationId,
            'reference'       => 'ORD-' . date('Y') . '-' . str_pad(Ordonnance::count() + 1, 4, '0', STR_PAD_LEFT),
            'date_ordonnance' => $request->date_ordonnance,
        ]);

        foreach ($request->lignes as $ligne) {
            $ordonnance->lignes()->create($ligne);
        }

        return redirect()->route('consultation.show', $consultationId)
            ->with('success', 'Ordonnance créée avec succès.');
    }

    // Afficher ordonnance
    public function show($id)
    {
        $ordonnance = Ordonnance::with(
            'consultation.rendezVous.patient.user',
            'consultation.rendezVous.medecin.user',
            'lignes'
        )->findOrFail($id);

        return view('ordonnance.show', compact('ordonnance'));
    }

    // Télécharger PDF
    public function telecharger($id)
    {
        $ordonnance = Ordonnance::with(
            'consultation.rendezVous.patient.user',
            'consultation.rendezVous.medecin.user',
            'lignes'
        )->findOrFail($id);

        $pdf = Pdf::loadView('ordonnance.pdf', compact('ordonnance'));
        return $pdf->download('ordonnance-' . $ordonnance->reference . '.pdf');
    }
}
