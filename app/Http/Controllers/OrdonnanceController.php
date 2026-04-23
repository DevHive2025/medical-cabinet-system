<?php

namespace App\Http\Controllers;

use App\Models\Ordonnance;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdonnanceController extends Controller
{
    public function create($consultationId)
    {
        $consultation = Consultation::with('rendezVous.patient.user')->findOrFail($consultationId);
        return view('ordonnance.create', compact('consultation'));
    }

    public function store(Request $request, $consultationId)
    {
        $request->validate([
            'date_ordonnance'      => 'required|date',
            'lignes'               => 'required|array|min:1',
            'lignes.*.medicament'  => 'required|string',
            'lignes.*.dose'        => 'nullable|string',
            'lignes.*.posologie'   => 'nullable|string',
            'lignes.*.duree'       => 'nullable|string',
        ]);

        $ordonnance = Ordonnance::create([
            'consultation_id' => $consultationId,
            'reference'       => 'ORD-' . date('Y') . '-' . str_pad(Ordonnance::count() + 1, 4, '0', STR_PAD_LEFT),
            'date_ordonnance' => $request->date_ordonnance,
        ]);

        foreach ($request->lignes as $ligne) {
            $ordonnance->lignes()->create([
                'medicament' => $ligne['medicament'],
                'dose'       => $ligne['dose']      ?? null,
                'posologie'  => $ligne['posologie'] ?? null,
                'duree'      => $ligne['duree']     ?? null,
            ]);
        }

        return redirect()->route('consultation.show', $consultationId)
            ->with('success', 'Ordonnance créée avec succès.');
    }

    public function show($id)
    {
        $ordonnance = Ordonnance::with(
            'consultation.rendezVous.patient.user',
            'consultation.rendezVous.medecin.user',
            'lignes'
        )->findOrFail($id);

        return view('ordonnance.show', compact('ordonnance'));
    }

    public function edit($id)
    {
        if (auth()->user()->role === 'patient') abort(403);
        $ordonnance = Ordonnance::with('lignes', 'consultation')->findOrFail($id);
        return view('ordonnance.edit', compact('ordonnance'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role === 'patient') abort(403);
        $request->validate([
            'lignes'               => 'required|array|min:1',
            'lignes.*.medicament'  => 'required|string',
            'lignes.*.dose'        => 'nullable|string',
            'lignes.*.posologie'   => 'nullable|string',
            'lignes.*.duree'       => 'nullable|string',
        ]);

        $ordonnance = Ordonnance::findOrFail($id);
        $ordonnance->lignes()->delete();

        foreach ($request->lignes as $ligne) {
            $ordonnance->lignes()->create([
                'medicament' => $ligne['medicament'],
                'dose'       => $ligne['dose']      ?? null,
                'posologie'  => $ligne['posologie'] ?? null,
                'duree'      => $ligne['duree']     ?? null,
            ]);
        }

        return redirect()->route('ordonnance.show', $id)
            ->with('success', 'Ordonnance mise à jour.');
    }

    public function destroy($id)
    {
        if (auth()->user()->role === 'patient') abort(403);
        $ordonnance = Ordonnance::findOrFail($id);
        $consultationId = $ordonnance->consultation_id;
        $ordonnance->delete();

        return redirect()->route('consultation.show', $consultationId)
            ->with('success', 'Ordonnance supprimée.');
    }

    public function telecharger($id)
    {
        $ordonnance = Ordonnance::with(
            'consultation.rendezVous.patient.user',
            'consultation.rendezVous.medecin.user',
            'lignes'
        )->findOrFail($id);

        $pdf = Pdf::loadView('ordonnance.pdf', compact('ordonnance'));
        return response($pdf->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="ordonnance-' . $ordonnance->reference . '.pdf"',
        ]);
    }
}
