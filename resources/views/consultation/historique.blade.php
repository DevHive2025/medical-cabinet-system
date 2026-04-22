<x-app-layout>

<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Historique des Consultations</h2>
    <a href="{{ route('consultation.index') }}" class="text-green-600 hover:underline text-sm">← Retour</a>
</div>

<div class="space-y-4">
    @forelse($consultations as $consultation)
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="font-semibold text-gray-800">{{ $consultation->date }}</p>
                <p class="text-sm text-gray-500">Dr. {{ $consultation->rendezVous->medecin->user->nom }} {{ $consultation->rendezVous->medecin->user->prenom }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('consultation.show', $consultation->id) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded text-xs font-medium">Voir</a>
                <a href="{{ route('consultation.pdf', $consultation->id) }}" class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded text-xs font-medium">📄 PDF</a>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-blue-50 rounded-lg p-3">
                <p class="text-xs text-blue-500 font-medium mb-1">Diagnostic</p>
                <p class="text-sm text-gray-800">{{ $consultation->diagnostic }}</p>
            </div>
            <div class="bg-yellow-50 rounded-lg p-3">
                <p class="text-xs text-yellow-500 font-medium mb-1">Symptômes</p>
                <p class="text-sm text-gray-800">{{ Str::limit($consultation->symptomes, 60) }}</p>
            </div>
            <div class="bg-green-50 rounded-lg p-3">
                <p class="text-xs text-green-500 font-medium mb-1">Ordonnances</p>
                <p class="text-sm text-gray-800">{{ $consultation->ordonnances->count() }} ordonnance(s)</p>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-xl shadow p-12 text-center text-gray-400">Aucune consultation trouvée.</div>
    @endforelse
</div>

</x-app-layout>
