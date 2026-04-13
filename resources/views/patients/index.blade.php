@extends('layouts.app')

@section('title', 'Liste des Patients')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Liste des Patients</h2>
    <a href="{{ route('patients.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
        + Nouveau Patient
    </a>
</div>

<!-- Barre de recherche -->
<div class="mb-4">
    <input type="text" id="search" placeholder="Rechercher par nom, prénom ou email..."
        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm text-left" id="patientsTable">
        <thead class="bg-green-50 text-green-700 uppercase text-xs">
            <tr>
                <th class="px-6 py-4">Nom</th>
                <th class="px-6 py-4">Prénom</th>
                <th class="px-6 py-4">Email</th>
                <th class="px-6 py-4">Téléphone</th>
                <th class="px-6 py-4">Date de naissance</th>
                <th class="px-6 py-4">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100" id="patientsBody">
            @forelse($patients as $patient)
            <tr class="hover:bg-gray-50 transition patient-row">
                <td class="px-6 py-4 font-medium text-gray-800">{{ $patient->user->nom }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $patient->user->prenom }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $patient->user->email }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $patient->telephone }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $patient->date_naissance }}</td>
                <td class="px-6 py-4 flex items-center gap-2">
                    <a href="{{ route('patients.edit', $patient->id) }}" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-3 py-1 rounded text-xs font-medium transition">Modifier</a>
                    <form action="{{ route('patients.destroy', $patient->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Supprimer ce patient ?')" class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded text-xs font-medium transition">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr id="emptyRow">
                <td colspan="6" class="px-6 py-8 text-center text-gray-400">Aucun patient trouvé.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Message aucun résultat recherche -->
    <div id="noResult" class="hidden px-6 py-8 text-center text-gray-400">
        Aucun patient trouvé pour cette recherche.
    </div>
</div>

<script>
    document.getElementById('search').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        const rows  = document.querySelectorAll('.patient-row');
        let found   = 0;

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            if (text.includes(query)) {
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
