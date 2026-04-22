<x-app-layout>
    <div class="max-w-5xl mx-auto py-8 px-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Fiche Utilisateur</h2>
        <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
            <span class="w-2 h-2 bg-indigo-500 rounded-full "></span>
            Gestion complète des informations du profil ({{ ucfirst($user->role) }})
        </p>
    </div>
    
    <div class="flex items-center gap-3">
        <a href="{{ route('users.index') }}" 
           class="group inline-flex items-center px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl shadow-sm hover:bg-gray-50 hover:text-indigo-600 hover:border-indigo-200 transition-all duration-200 ease-in-out">
            <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-200" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Retour à la liste
        </a>
        
        <a href="{{ route('users.edit', $user->id) }}" 
           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-xl shadow-md hover:bg-indigo-700 hover:shadow-indigo-200 transition-all duration-200">
            <i class="fas fa-user-edit mr-2 text-xs text-indigo-100"></i>
            Modifier
        </a>
    </div>
</div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="p-8">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div class="relative">
                        <div class="bg-gradient-to-br from-indigo-500 via-indigo-600 to-purple-700 text-white rounded-full w-28 h-28 flex items-center justify-center text-3xl font-black shadow-xl ring-4 ring-indigo-50 border-4 border-white">
                            {{ strtoupper(substr($user->nom, 0, 1)) }}{{ strtoupper(substr($user->prenom, 0, 1)) }}
                        </div>

                        @if($user->isOnline())
                            <span class="absolute bottom-1 right-1 block h-6 w-6 rounded-full ring-4 ring-white bg-green-500 shadow-sm "></span>
                        @else
                            <span class="absolute bottom-1 right-1 block h-6 w-6 rounded-full ring-4 ring-white bg-gray-300 shadow-sm"></span>
                        @endif
                    </div>
                    
                    <div class="flex-1 text-center md:text-left">
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mb-2">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $user->nom }} {{ $user->prenom }}</h1>
                            <span class="px-3 py-1 {{ $user->isAdmin() ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }} text-xs font-black rounded-full uppercase tracking-widest">
                                {{ $user->role }}
                            </span>
                        </div>
                        <div class="flex flex-wrap justify-center md:justify-start gap-y-2 gap-x-6 text-sm text-gray-500">
                            <span class="flex items-center gap-1"><i class="far fa-envelope"></i> {{ $user->email }}</span>
                            @if($user->isPatient() && $user->patient)
                                <span class="flex items-center gap-1"><i class="fas fa-id-card"></i> {{ $user->patient->cin }}</span>
                                <span class="flex items-center gap-1"><i class="fas fa-phone"></i> {{ $user->patient->telephone }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <h3 class="text-sm font-bold text-gray-900 uppercase mb-4 border-b pb-2">Informations Spécifiques</h3>
                    
                    @if($user->isPatient() && $user->patient)
                        <div class="space-y-4">
                            <div>
                                <label class="text-[10px] text-gray-400 font-bold uppercase">Date de Naissance</label>
                                <p class="text-sm font-medium text-gray-700">{{ \Carbon\Carbon::parse($user->patient->date_naissance)->format('d/m/Y') }}</p>
                            </div>
                            @if($user->patient->dossierMedical)
                                <div>
                                    <label class="text-[10px] text-gray-400 font-bold uppercase">Groupe Sanguin</label>
                                    <p class="text-sm font-black text-red-600">{{ $user->patient->dossierMedical->groupe_sanguin ?? 'N/A' }}</p>
                                </div>
                            @endif
                        </div>

                    @elseif($user->isMedecin() && $user->medecin)
                        <div class="space-y-4">
                            <div>
                                <label class="text-[10px] text-gray-400 font-bold uppercase">Spécialité</label>
                                <p class="text-sm font-medium text-blue-600">{{ $user->medecin->specialite }}</p>
                            </div>
                            <div>
                                <label class="text-[10px] text-gray-400 font-bold uppercase">Tél Cabinet</label>
                                <p class="text-sm font-medium text-gray-700">{{ $user->medecin->cabinet_telephone }}</p>
                            </div>
                        </div>

                    @elseif($user->isSecretaire() && $user->secretaire)
                        <div>
                            <label class="text-[10px] text-gray-400 font-bold uppercase">Bureau</label>
                            <p class="text-sm font-medium text-gray-700">Bureau N°: {{ $user->secretaire->bureau }}</p>
                        </div>
                    @else
                        <p class="text-sm text-gray-400 italic">Aucune information supplémentaire.</p>
                    @endif
                </div>

                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                    <h3 class="text-sm font-bold text-gray-900 uppercase mb-4">Activité</h3>
                    <div class="text-xs space-y-2 text-gray-500">
                        <p>Créé le : <b>{{ $user->created_at->format('d/m/Y') }}</b></p>
                        <p>Dernière maj : <b>{{ $user->updated_at->diffForHumans() }}</b></p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                @if($user->isPatient() && $user->patient)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                            <h3 class="font-bold text-gray-900">Dossier Médical & Consultations</h3>
                            <i class="fas fa-notes-medical text-green-500"></i>
                        </div>
                        <div class="p-6">
                            @if($user->patient->dossierMedical)
                                <div class="grid grid-cols-2 gap-4 mb-8">
                                    <div class="bg-red-50 p-3 rounded-xl border border-red-100">
                                        <span class="text-[10px] font-bold text-red-400 uppercase">Allergies</span>
                                        <p class="text-xs text-red-700">{{ $user->patient->dossierMedical->allergies ?: 'Aucune' }}</p>
                                    </div>
                                    <div class="bg-blue-50 p-3 rounded-xl border border-blue-100">
                                        <span class="text-[10px] font-bold text-blue-400 uppercase">Maladies Chroniques</span>
                                        <p class="text-xs text-blue-700">{{ $user->patient->dossierMedical->maladies_chroniques ?: 'Aucune' }}</p>
                                    </div>
                                </div>
                            @endif

                            <h4 class="text-xs font-bold text-gray-400 uppercase mb-4">Historique Récent</h4>
                            <div class="space-y-4">
                                @forelse($user->patient->consultations->sortByDesc('created_at')->take(5) as $consultation)
                                    <div class="flex items-start gap-4 p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition">
                                        <div class="p-2 bg-white rounded-lg shadow-sm">
                                            <i class="fas fa-calendar-check text-blue-500"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between">
                                                <p class="text-sm font-bold text-gray-900">{{ $consultation->created_at->format('d M Y') }}</p>
                                                <span class="text-[10px] text-blue-600 font-mono">#{{ $consultation->id }}</span>
                                            </div>
                                            <p class="text-xs text-gray-600 mt-1 line-clamp-1"><b>Diagnostic:</b> {{ $consultation->diagnostic }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-400 text-center py-4">Aucune consultation enregistrée.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
                        <i class="fas fa-user-shield text-gray-200 text-5xl mb-4"></i>
                        <p class="text-gray-500">Les logs d'activité pour ce rôle seront bientôt disponibles.</p>
                    </div>
                @endif
            </div>

        </div>

        <div class="border-t border-gray-100 pt-8 mt-12 flex justify-center gap-4">
             <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" onclick="return confirm('Confirmer la suppression ?')" class="text-sm font-semibold text-red-500 hover:text-red-700 transition">
                    Supprimer l'utilisateur
                </button>
            </form>
        </div>
    </div>
</x-app-layout>