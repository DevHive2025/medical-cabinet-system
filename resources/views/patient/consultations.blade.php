<x-app-layout>
<div class="max-w-7xl mx-auto py-8">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Mes Consultations</h1>
            <p class="text-sm text-gray-500 mt-1">Historique de vos consultations médicales</p>
        </div>

        <!-- Barre de recherche -->
        <div class="mb-4">
            <input type="text" id="search" placeholder="Rechercher par médecin, diagnostic..."
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Liste des consultations -->
        <div class="space-y-4" id="consultationsList">
            @forelse($consultations as $consultation)
            <div class="bg-white rounded-xl shadow p-6 consultation-item">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-blue-100 text-blue-700 rounded-full w-10 h-10 flex items-center justify-center font-bold text-sm">
                            Dr
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Dr. {{ $consultation->rendezVous->medecin->user->nom }} {{ $consultation->rendezVous->medecin->user->prenom }}</p>
                            <p class="text-xs text-gray-500">{{ $consultation->rendezVous->medecin->specialite ?? '' }}</p>
                        </div>
                    </div>
                    <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">{{ $consultation->date }}</span>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-blue-50 rounded-lg p-3">
                        <p class="text-xs text-blue-500 font-medium mb-1">Diagnostic</p>
                        <p class="text-sm text-gray-800">{{ $consultation->diagnostic }}</p>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-3">
                        <p class="text-xs text-yellow-500 font-medium mb-1">Symptômes</p>
                        <p class="text-sm text-gray-800">{{ $consultation->symptomes }}</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-3">
                        <p class="text-xs text-green-500 font-medium mb-1">Compte Rendu</p>
                        <p class="text-sm text-gray-800">{{ Str::limit($consultation->compte_rendu, 80) }}</p>
                    </div>
                </div>

                @if($consultation->ordonnances && $consultation->ordonnances->count() > 0)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-500 font-medium mb-2">💊 Ordonnances :</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($consultation->ordonnances as $ordonnance)
                        <a href="{{ route('ordonnance.show', $ordonnance->id) }}"
                           class="inline-flex items-center gap-1 bg-green-50 hover:bg-green-100 text-green-700 text-xs px-3 py-2 rounded-lg transition font-medium">
                            📄 {{ $ordonnance->reference }}
                        </a>
                        <a href="{{ route('ordonnance.telecharger', $ordonnance->id) }}"
                           class="inline-flex items-center gap-1 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs px-3 py-2 rounded-lg transition font-medium">
                            ⬇️ PDF
                        </a>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-400">Aucune ordonnance pour cette consultation.</p>
                </div>
                @endif
            </div>
            @empty
            <div class="bg-white rounded-xl shadow p-12 text-center">
                <div class="text-5xl mb-4">🩺</div>
                <p class="text-gray-500 font-medium">Aucune consultation trouvée.</p>
            </div>
            @endforelse
        </div>

        <!-- Message aucun résultat -->
        <div id="noResult" class="hidden bg-white rounded-xl shadow p-12 text-center">
            <p class="text-gray-400">Aucune consultation trouvée pour cette recherche.</p>
        </div>
</div>
</x-app-layout>


    <script>
        document.getElementById('search').addEventListener('input', function () {
            const query = this.value.toLowerCase();
            const items = document.querySelectorAll('.consultation-item');
            let found = 0;

            items.forEach(item => {
                if (item.innerText.toLowerCase().includes(query)) {
                    item.style.display = '';
                    found++;
                } else {
                    item.style.display = 'none';
                }
            });

            document.getElementById('noResult').classList.toggle('hidden', found > 0);
        });
    </script>


