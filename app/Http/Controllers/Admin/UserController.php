<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\Medecin; 
use App\Models\Secretaire;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all(); 
        
        $stats = [
            'total' => User::count(),
            'medecins' => Medecin::count(),
            'secretaires' => Secretaire::count(),
            'patients' => Patient::count(), 

        ];

        return view('admin.users', compact('users', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // On définit les rôles disponibles pour le formulaire
        $roles = ['medecin', 'secretaire', 'patient'];
        return view('admin.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:medecin,secretaire,patient',
            
            // Validation spécifique selon le rôle choisi
            'specialite' => 'required_if:role,medecin',
            'cabinet_telephone' => 'required_if:role,medecin',
            'bureau' => 'required_if:role,secretaire',
            'cin' => 'required_if:role,patient',
            'telephone' => 'required_if:role,patient',
            'date_naissance' => 'required_if:role,patient|date|nullable',
            'genre' => 'required_if:role,patient|in:Homme,Femme',
        ]);

        // 2. Génération automatique du mot de passe (Ex: Nom@2026)
        $motDePasseParDefaut = ucfirst($request->nom) . '@2026';

        try {
            // Utilisation d'une transaction pour garantir l'intégrité des données
            DB::beginTransaction();

            // 3. Création de l'utilisateur principal
            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'password' => Hash::make($motDePasseParDefaut),
                'role' => $request->role,
            ]);

            // 4. Création du profil lié selon le rôle
            if ($request->role === 'medecin') {
                Medecin::create([
                    'user_id' => $user->id,
                    'specialite' => $request->specialite,
                    'cabinet_telephone' => $request->cabinet_telephone,
                ]);
            } 
            elseif ($request->role === 'secretaire') {
                Secretaire::create([
                    'user_id' => $user->id,
                    'bureau' => $request->bureau,
                ]);
            } 
            elseif ($request->role === 'patient') {
                $patient = Patient::create([
                    'user_id' => $user->id,
                    'cin' => $request->cin,
                    'genre' => $request->genre,
                    'telephone' => $request->telephone,
                    'date_naissance' => $request->date_naissance,
                ]);
                
                // Création automatique d'un dossier médical vide
                $patient->dossierMedical()->create([
                    'groupe_sanguin' => 'Inconnu'
                ]);
            }

            DB::commit();

            // Redirection avec message de succès
            return redirect()->route('users.index')->with('success', "Utilisateur créé avec succès ! Le mot de passe par défaut est : {$motDePasseParDefaut}");

        } catch (\Exception $e) {
            // En cas d'erreur, on annule tout
            DB::rollback();
            return back()->with('error', "Erreur lors de la création : " . $e->getMessage())->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        
        return view('admin.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user->load(['patient', 'medecin', 'secretaire']);
        return view('admin.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, User $user)
    {

        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('nom', 'prenom', 'email'));


        if ($user->isMedecin()) {
            $user->medecin->update($request->only('specialite', 'cabinet_telephone'));
        } elseif ($user->isPatient()) {
            $user->patient->update($request->only('cin', 'telephone', 'date_naissance'));
        } elseif ($user->isSecretaire()) {
            $user->secretaire->update($request->only('bureau'));
        }

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Empêcher l'administrateur de se supprimer lui-même
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Action impossible : vous ne pouvez pas supprimer votre propre compte.');
        }

        // Suppression de l'utilisateur
        $user->delete();

        return back()->with('success', 'L\'utilisateur a été supprimé avec succès.');
    }
}
