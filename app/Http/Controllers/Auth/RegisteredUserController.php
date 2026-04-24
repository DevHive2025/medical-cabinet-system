<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'cin' => ['required', 'string', 'max:255', 'unique:patients,cin'],
            'date_naissance' => ['required', 'date'],
            'telephone' => ['required', 'string', 'max:20'],
            'genre' => ['required', 'string', 'in:homme,femme'],

        ]);

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_PATIENT,
        ]);
        $patient = $user->patient()->create([
            'cin' => $request->cin,
            'date_naissance' => $request->date_naissance,
            'telephone' => $request->telephone,
            'genre' => $request->genre, 
        ]);

        event(new Registered($user));

        Auth::login($user);


        return redirect('/patient/dashboard');
    }
}
