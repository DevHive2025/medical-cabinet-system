<x-app-layout>
<div class="max-w-7xl mx-auto py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Mes Consultations</h1>

        <div class="space-y-4">
            @forelse($consultations as $consultation)
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-green-100 text-green-700 rounded-full w-10 h-10 flex items-center justify-center font-bold text-sm">
                            {{ strtoupper(substr($consultation->rendezVous->patient->user->nom, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $consultation->rendezVous->patient->user->nom }} {{ $consultation->rendezVous->patient->user->prenom }}</p>
                            <p class="text-xs text-gray-500">{{ $consultation->rendezVous->patient->user->email }}</p>
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

                <div class="mt-4 flex gap-2">
                    @if(!$consultation->ordonnances || $consultation->ordonnances->count() == 0)
                        <a href="{{ route('ordonnance.create', $consultation->id) }}"
                           class="bg-green-100 hover:bg-green-200 text-green-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                            + Créer Ordonnance
                        </a>
                    @else
                        <a href="{{ route('ordonnance.show', $consultation->ordonnances->first()->id) }}"
                           class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                            Voir Ordonnance
                        </a>
                        <a href="{{ route('ordonnance.telecharger', $consultation->ordonnances->first()->id) }}"
                           class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                            📥 Télécharger PDF
                        </a>
                    @endif
                </div>
            </div>
            @empty
            <div class="bg-white rounded-xl shadow p-12 text-center">
                <p class="text-gray-400">Aucune consultation trouvée.</p>
            </div>
            @endforelse
        </div>
 </div>
</x-app-layout>