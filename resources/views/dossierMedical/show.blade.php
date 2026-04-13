@extends('layouts.app')

@section('title', 'Détails Dossier Médical')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Dossier Médical</h2>
    <div class="flex gap-3">
        <a href="{{ route('dossierMedical.edit', $dossierMedical->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">Modifier</a>
        <a href="{{ route('dossierMedical.index') }}" class="text-green-600 hover:underline text-sm self-center">← Retour</a>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-8 max-w-2xl">

    <div class="flex items-center gap-4 mb-6">
        <div class="bg-green-100 text-green-700 rounded-full w-14 h-14 flex items-center justify-center text-xl font-bold">
            {{ strtoupper(substr($dossierMedical->patient->user->nom, 0, 1)) }}{{ strtoupper(substr($dossierMedical->patient->user->prenom, 0, 1)) }}
        </div>
        <div>
            <p class="text-lg font-semibold text-gray-800">{{ $dossierMedical->patient->user->nom }} {{ $dossierMedical->patient->user->prenom }}</p>
            <p class="text-sm text-gray-500">{{ $dossierMedical->patient->user->email }}</p>
        </div>
    </div>

    <div class="divide-y divide-gray-100">
        <div class="py-4">
            <p class="text-sm text-gray-500 mb-1">Historique</p>
            <p class="text-sm text-gray-800">{{ $dossierMedical->historique ?? '—' }}</p>
        </div>
        <div class="py-4">
            <p class="text-sm text-gray-500 mb-1">Antécédents</p>
            <p class="text-sm text-gray-800">{{ $dossierMedical->antecedents ?? '—' }}</p>
        </div>
        <div class="py-4">
            <p class="text-sm text-gray-500 mb-1">Allergies</p>
            <p class="text-sm text-gray-800">{{ $dossierMedical->allergies ?? '—' }}</p>
        </div>
    </div>

    <div class="mt-6">
        <form action="{{ route('dossierMedical.destroy', $dossierMedical->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Supprimer ce dossier ?')"
                class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg font-medium transition">
                Supprimer ce dossier
            </button>
        </form>
    </div>
</div>

@endsection
