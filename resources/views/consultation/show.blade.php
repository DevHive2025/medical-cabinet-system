@extends('layouts.app')
@section('title', 'Détails Consultation')
@section('content')

<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Détails de la Consultation</h2>
    <div class="flex gap-3">
        <a href="{{ route('consultation.pdf', $consultation->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">📄 Télécharger PDF</a>
        <a href="{{ route('ordonnance.create', $consultation->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">+ Ordonnance</a>
        <a href="{{ route('consultation.edit', $consultation->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">Modifier</a>
        <a href="{{ route('consultation.index') }}" class="text-green-600 hover:underline text-sm self-center">← Retour</a>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-8 max-w-2xl">

    <div class="flex items-center gap-4 mb-6">
        <div class="bg-green-100 text-green-700 rounded-full w-14 h-14 flex items-center justify-center text-xl font-bold">
            {{ strtoupper(substr($consultation->rendezVous->patient->user->nom, 0, 1)) }}
        </div>
        <div>
            <p class="text-lg font-semibold text-gray-800">{{ $consultation->rendezVous->patient->user->nom }} {{ $consultation->rendezVous->patient->user->prenom }}</p>
            <p class="text-sm text-gray-500">Dr. {{ $consultation->rendezVous->medecin->user->nom }} — {{ $consultation->date }}</p>
        </div>
    </div>

    <div class="divide-y divide-gray-100">
        <div class="py-4">
            <p class="text-xs text-gray-500 uppercase font-medium mb-1">Diagnostic</p>
            <p class="text-sm text-gray-800">{{ $consultation->diagnostic }}</p>
        </div>
        <div class="py-4">
            <p class="text-xs text-gray-500 uppercase font-medium mb-1">Symptômes</p>
            <p class="text-sm text-gray-800">{{ $consultation->symptomes }}</p>
        </div>
        <div class="py-4">
            <p class="text-xs text-gray-500 uppercase font-medium mb-1">Compte Rendu</p>
            <p class="text-sm text-gray-800 leading-relaxed">{{ $consultation->compte_rendu }}</p>
        </div>
    </div>

    <div class="mt-6">
        <form action="{{ route('consultation.destroy', $consultation->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Supprimer cette consultation ?')"
                class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg font-medium transition">
                Supprimer
            </button>
        </form>
    </div>
</div>

@endsection
