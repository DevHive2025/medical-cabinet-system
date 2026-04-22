<x-app-layout>
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Liste des Patients</h1>

        <div class="mb-4">
            <input type="text" id="search" placeholder="Rechercher..."
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400">
        </div>

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-purple-50 text-purple-700 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">Nom</th>
                        <th class="px-6 py-4">Prénom</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Téléphone</th>
                        <th class="px-6 py-4">Date naissance</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($patients as $patient)
                    <tr class="hover:bg-gray-50 transition patient-row">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $patient->user->nom }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $patient->user->prenom }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $patient->user->email }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $patient->telephone }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $patient->date_naissance }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Aucun patient trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

    <script>
        document.getElementById('search').addEventListener('input', function () {
            const query = this.value.toLowerCase();
            document.querySelectorAll('.patient-row').forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(query) ? '' : 'none';
            });
        });
    </script>


