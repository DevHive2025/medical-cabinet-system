<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class controllerPatient extends Controller
{
    public function index(Request $request)
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
            'nom'                  => 'required',
            'prenom'               => 'required',
            'email'                => 'required|email|unique:users',
            'password'             => 'required|confirmed|min:6',
            'num_securite_sociale' => 'required|unique:patients',
            'date_naissance'       => 'required|date',
            'telephone'            => 'required',
            'adresse'              => 'nullable',
        ]);

        $user = User::create([
            'nom'      => $request->nom,
            'prenom'   => $request->prenom,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'patient',
        ]);

        Patient::create([
            'user_id'              => $user->id,
            'num_securite_sociale' => $request->num_securite_sociale,
            'date_naissance'       => $request->date_naissance,
            'telephone'            => $request->telephone,
            'adresse'              => $request->adresse,
        ]);

        return redirect()->route('patients.index')->with('success', 'Patient créé avec succès.');
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
            'nom'                  => 'required',
            'prenom'               => 'required',
            'email'                => 'required|email|unique:users,email,' . $patient->user_id,
            'num_securite_sociale' => 'required|unique:patients,num_securite_sociale,' . $id,
            'date_naissance'       => 'required|date',
            'telephone'            => 'required',
            'adresse'              => 'nullable',
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
            'num_securite_sociale' => $request->num_securite_sociale,
            'date_naissance'       => $request->date_naissance,
            'telephone'            => $request->telephone,
            'adresse'              => $request->adresse,
        ]);

        return redirect()->route('patients.index')->with('success', 'Patient mis à jour.');
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->user->delete();
        return redirect()->route('patients.index')->with('success', 'Patient supprimé.');
    }
}
