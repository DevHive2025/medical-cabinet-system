@extends('layouts.app')
@section('title', 'Modifier Consultation')
@section('content')

<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Modifier la Consultation</h2>
    <a href="{{ route('consultation.index') }}" class="text-green-600 hover:underline text-sm">← Retour</a>
</div>

<div class="bg-white rounded-xl shadow p-8 max-w-2xl">
    <form action="{{ route('consultation.update', $consultation->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Rendez-vous</label>
            <select name="rendez_vous_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                @foreach($rendezVous as $rdv)
                    <option value="{{ $rdv->id }}" {{ old('rendez_vous_id', $consultation->rendez_vous_id) == $rdv->id ? 'selected' : '' }}>
                        {{ $rdv->patient->user->nom }} — Dr. {{ $rdv->medecin->user->nom }} — {{ $rdv->date_heure }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
            <input type="date" name="date" value="{{ old('date', $consultation->date) }}" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Symptômes</label>
            <textarea name="symptomes" rows="3" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">{{ old('symptomes', $consultation->symptomes) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Diagnostic</label>
            <input type="text" name="diagnostic" value="{{ old('diagnostic', $consultation->diagnostic) }}" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Compte Rendu</label>
            <textarea name="compte_rendu" rows="5" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">{{ old('compte_rendu', $consultation->compte_rendu) }}</textarea>
        </div>

        <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg font-medium transition">
            Mettre à jour
        </button>
    </form>
</div>

@endsection
