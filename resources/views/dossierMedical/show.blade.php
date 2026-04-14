<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Dossier Médical</h2>
                <p class="text-sm text-gray-500 mt-1">Consultez les informations cliniques et l'historique du patient.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('dossierMedical.edit', $dossierMedical->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold rounded-lg shadow-sm transition duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                    Modifier
                </a>
                <a href="{{ route('dossierMedical.index') }}" class="inline-flex items-center px-4 py-2 text-gray-600 hover:text-gray-900 text-sm font-medium transition">
                    ← Retour
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="p-8">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="bg-gradient-to-br from-green-100 to-green-200 text-green-700 rounded-2xl w-24 h-24 flex items-center justify-center text-3xl font-bold shadow-inner">
                        {{ strtoupper(substr($dossierMedical->patient->user->nom, 0, 1)) }}{{ strtoupper(substr($dossierMedical->patient->user->prenom, 0, 1)) }}
                    </div>
                    
                    <div class="flex-1 text-center md:text-left">
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mb-2">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $dossierMedical->patient->user->nom }} {{ $dossierMedical->patient->user->prenom }}</h1>
                            <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-black rounded-full uppercase tracking-widest">
                                {{ $dossierMedical->groupe_sanguin ?? 'Inconnu' }}
                            </span>
                        </div>
                        <div class="flex flex-wrap justify-center md:justify-start gap-y-2 gap-x-6 text-sm text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                {{ $dossierMedical->patient->cin ?? 'N/A' }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                {{ $dossierMedical->patient->user->email }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Maladies Chroniques</h4>
                        <p class="text-sm text-gray-700 font-medium leading-relaxed">
                            {{ $dossierMedical->maladies_chroniques ?: 'Aucune signalée' }}
                        </p>
                    </div>
                    <div class="p-4 bg-red-50 rounded-xl border border-red-100">
                        <h4 class="text-xs font-bold text-red-400 uppercase tracking-wider mb-3">Allergies</h4>
                        <p class="text-sm text-red-700 font-bold leading-relaxed">
                            {{ $dossierMedical->allergies ?: 'Aucune connue' }}
                        </p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Antécédents</h4>
                        <p class="text-sm text-gray-700 leading-relaxed italic">
                            {{ $dossierMedical->antecedents ?: 'Aucun antécédent' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Historique des Consultations
            </h3>

            <div class="space-y-4">
                @forelse($dossierMedical->patient->consultations->sortByDesc('created_at') as $consultation)
                    <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition duration-200">
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-green-50 rounded-lg text-green-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <p class="text-sm font-bold text-gray-900">{{ $consultation->created_at->format('d F Y') }}</p>
                            </div>
                            <span class="text-xs font-mono text-gray-400 bg-gray-50 px-2 py-1 rounded">#CNS-{{ $consultation->id }}</span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase">Symptômes & Observation</label>
                                <p class="text-sm text-gray-700 mt-1">{{ $consultation->symptomes ?? 'Non spécifiés' }}</p>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase">Diagnostic Final</label>
                                <p class="text-sm font-semibold text-blue-600 mt-1">{{ $consultation->diagnostic ?? 'En attente' }}</p>
                            </div>
                        </div>

                        @if($consultation->compte_rendu)
                        <div class="mt-4 pt-4 border-t border-gray-50">
                            <label class="text-[10px] font-bold text-gray-400 uppercase">Compte Rendu détaillé</label>
                            <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $consultation->compte_rendu }}</p>
                        </div>
                        @endif
                    </div>
                @empty
                    <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl py-12 text-center">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        <p class="text-gray-400 font-medium">Aucune consultation passée pour ce patient.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="border-t border-gray-100 pt-8 mt-12 text-center">
            <form action="{{ route('dossierMedical.destroy', $dossierMedical->id) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce dossier médical ?')"
                        class="text-sm font-semibold text-red-500 hover:text-red-700 transition">
                    Supprimer le dossier médical
                </button>
            </form>
            <p class="text-[10px] text-gray-400 mt-4 uppercase tracking-widest">
                Dernière mise à jour : {{ $dossierMedical->updated_at->diffForHumans() }}
            </p>
        </div>
    </div>
</x-app-layout>