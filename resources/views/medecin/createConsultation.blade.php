<x-app-layout>
<div class="max-w-7xl mx-auto py-8">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Créer une Consultation</h1>
            <a href="{{ route('medecin.rendezvous') }}" class="text-green-600 hover:underline text-sm">← Retour</a>
        </div>

        <!-- Infos RDV -->
        <div class="bg-blue-50 rounded-xl p-4 mb-6 flex items-center gap-4">
            <div class="bg-blue-600 text-white rounded-xl p-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-gray-800">{{ $rendezVous->patient->user->nom }} {{ $rendezVous->patient->user->prenom }}</p>
                <p class="text-sm text-gray-500">{{ $rendezVous->date_heure }} — {{ $rendezVous->motif }}</p>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow p-8 max-w-2xl">
            <form action="{{ route('medecin.consultation.store', $rendezVous->id) }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Symptômes</label>
                    <textarea name="symptomes" rows="3" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">{{ old('symptomes') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Diagnostic</label>
                    <input type="text" name="diagnostic" value="{{ old('diagnostic') }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Compte Rendu</label>
                    <textarea name="compte_rendu" rows="5" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">{{ old('compte_rendu') }}</textarea>
                </div>

                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-medium transition">
                    Enregistrer la Consultation
                </button>
            </form>
        </div>
</div>
</x-app-layout>

