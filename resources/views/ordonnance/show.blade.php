<x-app-layout>
<div class="max-w-7xl mx-auto py-8">

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">{{ session('success') }}</div>
        @endif

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Ordonnance</h1>
            <div class="flex gap-3">
                <a href="{{ route('ordonnance.telecharger', $ordonnance->id) }}"
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Télécharger PDF
                </a>
                @if(auth()->user()->role !== 'patient')
                <a href="{{ route('ordonnance.edit', $ordonnance->id) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                    Modifier
                </a>
                <form action="{{ route('ordonnance.destroy', $ordonnance->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Supprimer cette ordonnance ?')"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                        Supprimer
                    </button>
                </form>
                @endif
                @if(auth()->user()->role === 'patient')
                <a href="{{ route('patient.consultations') }}" class="text-green-600 hover:underline text-sm self-center">← Retour</a>
                @else
                <a href="{{ route('medecin.consultations') }}" class="text-green-600 hover:underline text-sm self-center">← Retour</a>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-8 max-w-2xl">

            <!-- Header ordonnance -->
            <div class="border-b pb-4 mb-6">
                <div class="flex justify-between">
                    <div>
                        <p class="font-bold text-gray-800 text-lg">Dr. {{ $ordonnance->consultation->rendezVous->medecin->user->nom }} {{ $ordonnance->consultation->rendezVous->medecin->user->prenom }}</p>
                        <p class="text-sm text-gray-500">{{ $ordonnance->consultation->rendezVous->medecin->specialite }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Réf: <span class="font-medium text-gray-800">{{ $ordonnance->reference }}</span></p>
                        <p class="text-sm text-gray-500">Date: <span class="font-medium text-gray-800">{{ $ordonnance->date_ordonnance }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Patient -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <p class="text-xs text-gray-500 uppercase mb-1">Patient</p>
                <p class="font-semibold text-gray-800">{{ $ordonnance->consultation->rendezVous->patient->user->nom }} {{ $ordonnance->consultation->rendezVous->patient->user->prenom }}</p>
            </div>

            <!-- Médicaments -->
            <h2 class="text-sm font-semibold text-gray-700 uppercase mb-3">Médicaments prescrits</h2>
            <div class="space-y-3">
                @foreach($ordonnance->lignes as $ligne)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $ligne->medicament }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ $ligne->posologie }}</p>
                        </div>
                        <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full">{{ $ligne->duree }}</span>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Signature -->
            <div class="mt-8 pt-4 border-t text-right">
                <p class="text-sm text-gray-500">Signature du médecin</p>
                <p class="font-semibold text-gray-800 mt-2">Dr. {{ $ordonnance->consultation->rendezVous->medecin->user->nom }}</p>
            </div>

        </div>
</div>
</x-app-layout>

