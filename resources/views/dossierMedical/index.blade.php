<x-app-layout>
    <div class="flex flex-col md:flex-row items-center justify-between mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-800">Dossiers Médicaux</h2>
            <p class="text-sm text-gray-500 mt-1">Gérez et consultez les informations cliniques de vos patients.</p>
        </div>

        <a href="{{ route('dossierMedical.create') }}"
           class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl transition-all shadow-sm hover:shadow-md active:scale-95">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Nouveau Dossier
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded-r-lg flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead class="bg-gray-50/50 border-b border-gray-100 text-gray-400 uppercase text-[11px] font-black tracking-widest">
                    <tr>
                        <th class="px-6 py-5">Patient & Identité</th>
                        <th class="px-6 py-5 text-center">G. Sanguin</th>
                        <th class="px-6 py-5">Maladies Chroniques</th>
                        <th class="px-6 py-5">Allergies</th>
                        <th class="px-6 py-5 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    @forelse($dossiers as $dossier)
                        <tr class="group hover:bg-green-50/30 transition-all duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold text-xs shadow-inner">
                                        {{ strtoupper(substr($dossier->patient->user->nom, 0, 1)) }}{{ strtoupper(substr($dossier->patient->user->prenom, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 group-hover:text-green-700 transition">
                                            {{ $dossier->patient->user->nom ?? '' }} {{ $dossier->patient->user->prenom ?? '' }}
                                        </div>
                                        <div class="text-[10px] text-gray-400 font-mono tracking-tighter">
                                            ID: {{ $dossier->patient->cin ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-black bg-red-50 text-red-600 border border-red-100 shadow-sm">
                                    {{ $dossier->groupe_sanguin ?? '—' }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <p class="text-xs text-gray-600 max-w-[180px] truncate" title="{{ $dossier->maladies_chroniques }}">
                                    {{ $dossier->maladies_chroniques ?: 'Aucune' }}
                                </p>
                            </td>

                            <td class="px-6 py-4">
                                <p class="text-xs text-red-500/80 font-medium max-w-[180px] truncate" title="{{ $dossier->allergies }}">
                                    {{ $dossier->allergies ?: 'Aucune' }}
                                </p>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('dossierMedical.show', $dossier->id) }}" 
                                       class="p-2 text-blue-500 hover:bg-blue-50 rounded-xl transition-all hover:scale-110" 
                                       title="Détails du dossier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>

                                    <a href="{{ route('dossierMedical.edit', $dossier->id) }}" 
                                       class="p-2 text-amber-500 hover:bg-amber-50 rounded-xl transition-all hover:scale-110" 
                                       title="Modifier le dossier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                        </svg>
                                    </a>

                                    <form action="{{ route('dossierMedical.destroy', $dossier->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Supprimer définitivement ce dossier ?')"
                                                class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all hover:scale-110" 
                                                title="Supprimer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="bg-gray-50 p-4 rounded-full mb-4">
                                        <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-400 font-medium text-base">Aucun dossier médical trouvé</p>
                                    <p class="text-gray-300 text-xs mt-1">Commencez par ajouter un nouveau dossier pour vos patients.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-gray-50/50 px-6 py-4 border-t border-gray-100 flex justify-between items-center text-[10px] text-gray-400 font-bold uppercase tracking-widest">
            <span>Total: {{ $dossiers->count() }} Dossiers</span>
            <span>Système de Gestion Médicale © 2026</span>
        </div>
    </div>
</x-app-layout>