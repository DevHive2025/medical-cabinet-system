@extends('layouts.app')
@section('title', 'Liste des Consultations')
@section('content')

<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Liste des Consultations</h2>
    <a href="{{ route('consultation.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
        + Nouvelle Consultation
    </a>
</div>

@if(session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
        {{ session('success') }}
    </div>
@endif

<div class="mb-4">
    <input type="text" id="search" placeholder="Rechercher par patient, médecin, diagnostic..."
        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-green-50 text-green-700 uppercase text-xs">
            <tr>
                <th class="px-6 py-4">Patient</th>
                <th class="px-6 py-4">Médecin</th>
                <th class="px-6 py-4">Date</th>
                <th class="px-6 py-4">Diagnostic</th>
                <th class="px-6 py-4">Symptômes</th>
                <th class="px-6 py-4">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100" id="consultationBody">
            @forelse($consultations as $consultation)
            <tr class="hover:bg-gray-50 transition consultation-row">
                <td class="px-6 py-4 font-medium text-gray-800">{{ $consultation->rendezVous->patient->user->nom }} {{ $consultation->rendezVous->patient->user->prenom }}</td>
                <td class="px-6 py-4 text-gray-600">Dr. {{ $consultation->rendezVous->medecin->user->nom }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $consultation->date }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $consultation->diagnostic }}</td>
                <td class="px-6 py-4 text-gray-600">{{ Str::limit($consultation->symptomes, 30) }}</td>
                <td class="px-6 py-4 flex items-center gap-2">
                    <a href="{{ route('consultation.show', $consultation->id) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded text-xs font-medium transition">Voir</a>
                    <a href="{{ route('consultation.edit', $consultation->id) }}" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-3 py-1 rounded text-xs font-medium transition">Modifier</a>
                    <form action="{{ route('consultation.destroy', $consultation->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Supprimer ?')" class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded text-xs font-medium transition">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-400">Aucune consultation trouvée.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div id="noResult" class="hidden px-6 py-8 text-center text-gray-400">Aucun résultat trouvé.</div>
</div>

<script>
    document.getElementById('search').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll('.consultation-row');
        let found = 0;
        rows.forEach(row => {
            if (row.innerText.toLowerCase().includes(query)) {
                row.style.display = '';
                found++;
            } else {
                row.style.display = 'none';
            }
        });
        document.getElementById('noResult').classList.toggle('hidden', found > 0);
    });
</script>

@endsection
