@extends('layouts.app')

@section('title', 'Détails Patient')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Détails du Patient</h2>
    <div class="flex gap-3">
        <a href="{{ route('patients.edit', $patient->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">Modifier</a>
        <a href="{{ route('patients.index') }}" class="text-green-600 hover:underline text-sm self-center">← Retour</a>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-8 max-w-2xl">

    <div class="flex items-center gap-4 mb-6">
        <div class="bg-green-100 text-green-700 rounded-full w-14 h-14 flex items-center justify-center text-xl font-bold">
            {{ strtoupper(substr($patient->user->nom, 0, 1)) }}{{ strtoupper(substr($patient->user->prenom, 0, 1)) }}
        </div>
        <div>
            <p class="text-lg font-semibold text-gray-800">{{ $patient->user->nom }} {{ $patient->user->prenom }}</p>
            <p class="text-sm text-gray-500">{{ $patient->user->email }}</p>
        </div>
    </div>

    <div class="divide-y divide-gray-100">
        <div class="flex justify-between py-3">
            <span class="text-sm text-gray-500">Numéro sécurité sociale</span>
            <span class="text-sm font-medium text-gray-800">{{ $patient->num_securite_sociale }}</span>
        </div>
        <div class="flex justify-between py-3">
            <span class="text-sm text-gray-500">Date de naissance</span>
            <span class="text-sm font-medium text-gray-800">{{ $patient->date_naissance }}</span>
        </div>
        <div class="flex justify-between py-3">
            <span class="text-sm text-gray-500">Téléphone</span>
            <span class="text-sm font-medium text-gray-800">{{ $patient->telephone }}</span>
        </div>
        <div class="flex justify-between py-3">
            <span class="text-sm text-gray-500">Adresse</span>
            <span class="text-sm font-medium text-gray-800">{{ $patient->adresse ?? '—' }}</span>
        </div>
    </div>

    <div class="mt-6">
        <form action="{{ route('patients.destroy', $patient->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Supprimer ce patient ?')"
                class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg font-medium transition">
                Supprimer ce patient
            </button>
        </form>
    </div>
</div>

@endsection
