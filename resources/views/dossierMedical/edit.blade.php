@extends('layouts.app')

@section('title', 'Modifier Dossier Médical')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Modifier le Dossier Médical</h2>
    <a href="{{ route('dossierMedical.index') }}" class="text-green-600 hover:underline text-sm">← Retour à la liste</a>
</div>

<div class="bg-white rounded-xl shadow p-8 max-w-2xl">
    <form action="{{ route('dossierMedical.update', $dossierMedical->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Patient</label>
            <select name="patient_id" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                <option value="">-- Sélectionner un patient --</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" {{ old('patient_id', $dossierMedical->patient_id) == $patient->id ? 'selected' : '' }}>
                        {{ $patient->user->nom }} {{ $patient->user->prenom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Historique</label>
            <textarea name="historique" rows="4"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">{{ old('historique', $dossierMedical->historique) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Antécédents</label>
            <textarea name="antecedents" rows="4"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">{{ old('antecedents', $dossierMedical->antecedents) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Allergies</label>
            <textarea name="allergies" rows="4"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">{{ old('allergies', $dossierMedical->allergies) }}</textarea>
        </div>

        <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg font-medium transition">
            Mettre à jour
        </button>
    </form>
</div>

@endsection
