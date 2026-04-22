<x-app-layout>
    <div class="max-w-7xl mx-auto py-8">

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">{{ session('success') }}</div>
        @endif

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Bonjour, {{ auth()->user()->prenom }} 👋</h1>
                <p class="text-sm text-gray-500 mt-1">Voici un aperçu de l'activité du cabinet</p>
            </div>
            <div class="text-sm text-gray-500">{{ now()->format('d/m/Y') }}</div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
                <div class="bg-blue-100 text-blue-600 rounded-xl p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalPatients }}</p>
                    <p class="text-sm text-gray-500">Patients</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
                <div class="bg-green-100 text-green-600 rounded-xl p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalMedecins }}</p>
                    <p class="text-sm text-gray-500">Médecins</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
                <div class="bg-yellow-100 text-yellow-600 rounded-xl p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalRendezVous }}</p>
                    <p class="text-sm text-gray-500">Rendez-vous</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
                <div class="bg-purple-100 text-purple-600 rounded-xl p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalConsultations }}</p>
                    <p class="text-sm text-gray-500">Consultations</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">

            <!-- Derniers RDV -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-base font-semibold text-gray-800 mb-4">Derniers Rendez-vous</h2>
                <div class="space-y-3">
                    @forelse($derniersRdv as $rdv)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $rdv->patient->user->nom }} {{ $rdv->patient->user->prenom }}</p>
                            <p class="text-xs text-gray-500">Dr. {{ $rdv->medecin->user->nom }} — {{ $rdv->date_heure }}</p>
                        </div>
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $rdv->statut == 'confirme' ? 'bg-green-100 text-green-700' :
                               ($rdv->statut == 'annule' ? 'bg-red-100 text-red-700' :
                               'bg-yellow-100 text-yellow-700') }}">
                            {{ $rdv->statut }}
                        </span>
                    </div>
                    @empty
                    <p class="text-sm text-gray-400">Aucun rendez-vous.</p>
                    @endforelse
                </div>
            </div>

            <!-- RDV en attente -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-base font-semibold text-gray-800 mb-4">
                    RDV en attente
                    @if($rdvEnAttente->count() > 0)
                        <span class="ml-2 bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">{{ $rdvEnAttente->count() }}</span>
                    @endif
                </h2>
                <div class="space-y-3">
                    @forelse($rdvEnAttente as $rdv)
                    <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $rdv->patient->user->nom }} {{ $rdv->patient->user->prenom }}</p>
                            <p class="text-xs text-gray-500">Dr. {{ $rdv->medecin->user->nom }} — {{ $rdv->date_heure }}</p>
                        </div>
                        <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">en_attente</span>
                    </div>
                    @empty
                    <p class="text-sm text-gray-400">Aucun RDV en attente.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</x-app-layout>

