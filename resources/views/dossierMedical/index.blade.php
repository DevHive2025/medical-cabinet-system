@extends('layouts.app')

@section('title', 'Liste des Dossiers Médicaux')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Liste des Dossiers Médicaux</h2>
    <a href="{{ route('dossierMedical.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
        + Nouveau Dossier
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-green-50 text-green-700 uppercase text-xs">
            <tr>
                <th class="px-6 py-4">Patient</th>
                <th class="px-6 py-4">Historique</th>
                <th class="px-6 py-4">Antécédents</th>
                <th class="px-6 py-4">Allergies</th>
                <th class="px-6 py-4">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($dossiers as $dossier)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-medium text-gray-800">{{ $dossier->patient->user->nom }} {{ $dossier->patient->user->prenom }}</td>
                <td class="px-6 py-4 text-gray-600">{{ Str::limit($dossier->historique, 40) ?? '—' }}</td>
                <td class="px-6 py-4 text-gray-600">{{ Str::limit($dossier->antecedents, 40) ?? '—' }}</td>
                <td class="px-6 py-4 text-gray-600">{{ Str::limit($dossier->allergies, 40) ?? '—' }}</td>
                <td class="px-6 py-4 flex items-center gap-2">
                    <a href="{{ route('dossierMedical.show', $dossier->id) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded text-xs font-medium transition">Voir</a>
                    <a href="{{ route('dossierMedical.edit', $dossier->id) }}" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-3 py-1 rounded text-xs font-medium transition">Modifier</a>
                    <form action="{{ route('dossierMedical.destroy', $dossier->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Supprimer ce dossier ?')" class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded text-xs font-medium transition">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-400">Aucun dossier médical trouvé.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
