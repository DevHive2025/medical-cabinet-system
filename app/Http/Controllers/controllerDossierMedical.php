<?php

namespace App\Http\Controllers;

use App\Models\DossierMedical;
use App\Models\Patient;
use Illuminate\Http\Request;

class controllerDossierMedical extends Controller
{
    public function index()
    {
        $dossiers = DossierMedical::with('patient.user')->get();
        return view('dossierMedical.index', compact('dossiers'));
    }

    public function create()
    {
        $patients = Patient::with('user')->get();
        return view('dossierMedical.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'  => 'required|exists:patients,id',
            'historique'  => 'nullable|string',
            'antecedents' => 'nullable|string',
            'allergies'   => 'nullable|string',
        ]);

        DossierMedical::create($request->all());
        return redirect()->route('dossierMedical.index')->with('success', 'Dossier créé.');
    }

    public function show($dossierMedical)
    {
        $dossierMedical = DossierMedical::with('patient.user')->findOrFail($dossierMedical);
        return view('dossierMedical.show', compact('dossierMedical'));
    }

    public function edit($dossierMedical)
    {
        $dossierMedical = DossierMedical::findOrFail($dossierMedical);
        $patients       = Patient::with('user')->get();
        return view('dossierMedical.edit', compact('dossierMedical', 'patients'));
    }

    public function update(Request $request, $dossierMedical)
    {
        $request->validate([
            'patient_id'  => 'required|exists:patients,id',
            'historique'  => 'nullable|string',
            'antecedents' => 'nullable|string',
            'allergies'   => 'nullable|string',
        ]);

        DossierMedical::findOrFail($dossierMedical)->update($request->all());
        return redirect()->route('dossierMedical.index')->with('success', 'Dossier mis à jour.');
    }

    public function destroy($dossierMedical)
    {
        DossierMedical::findOrFail($dossierMedical)->delete();
        return redirect()->route('dossierMedical.index')->with('success', 'Dossier supprimé.');
    }
}
