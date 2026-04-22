<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Liste des Médecins</h1>

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-purple-50 text-purple-700 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">Nom</th>
                        <th class="px-6 py-4">Prénom</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Spécialité</th>
                        <th class="px-6 py-4">Téléphone</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($medecins as $medecin)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $medecin->user->nom }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $medecin->user->prenom }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $medecin->user->email }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium">{{ $medecin->specialite }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $medecin->cabinet_telephone }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Aucun médecin trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
