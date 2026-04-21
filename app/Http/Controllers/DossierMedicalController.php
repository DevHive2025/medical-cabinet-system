<?php

namespace App\Http\Controllers;

use App\Models\DossierMedical;
use App\Models\Patient;
use Illuminate\Http\Request;

class DossierMedicalController extends Controller // بدلت السمية لـ CamelCase (Standard)
{
    public function index()
    {
        $dossiers = DossierMedical::with('patient.user')->get();
        return view('dossierMedical.index', compact('dossiers'));
    }

    public function create()
    {
        
        $patients = Patient::doesntHave('dossierMedical')->with('user')->get();
        return view('dossierMedical.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'          => 'required|exists:patients,id|unique:dossier_medicals,patient_id',
            'groupe_sanguin'      => 'nullable|string|max:5',
            'maladies_chroniques' => 'nullable|string',
            'antecedents'         => 'nullable|string',
            'allergies'           => 'nullable|string',
        ]);

        DossierMedical::create($request->all());

        return redirect()->route('dossierMedical.index')->with('success', 'Dossier créé avec succès.');
    }

    public function show(DossierMedical $dossierMedical) // Route Model Binding
    {
        $dossierMedical->load(['patient.user', 'patient.consultations.rendezVous']);
        return view('dossierMedical.show', compact('dossierMedical'));
    }

    public function edit(DossierMedical $dossierMedical)
    {
        $patients = Patient::with('user')->get();
        return view('dossierMedical.edit', compact('dossierMedical', 'patients'));
    }

    public function update(Request $request, DossierMedical $dossierMedical)
    {
        $request->validate([
            'patient_id'          => 'required|exists:patients,id|unique:dossier_medicals,patient_id,' . $dossierMedical->id,
            'groupe_sanguin'      => 'nullable|string|max:5',
            'maladies_chroniques' => 'nullable|string',
            'antecedents'         => 'nullable|string',
            'allergies'           => 'nullable|string',
        ]);

        $dossierMedical->update($request->all());

        return redirect()->route('dossierMedical.index')->with('success', 'Dossier mis à jour.');
    }

    public function destroy(DossierMedical $dossierMedical)
    {
        $dossierMedical->delete();
        return redirect()->route('dossierMedical.index')->with('success', 'Dossier supprimé.');
    }
}