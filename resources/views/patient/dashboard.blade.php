<x-app-layout>
<div class="max-w-7xl mx-auto py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Bonjour, {{ auth()->user()->prenom }} 👋</h1>
                <p class="text-sm text-gray-500 mt-1">Voici un aperçu de votre santé</p>
            </div>
            <div class="text-sm text-gray-500">{{ now()->format('d/m/Y') }}</div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
                <div class="bg-blue-100 text-blue-600 rounded-xl p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $prochainRendezVous ? 1 : 0 }}</p>
                    <p class="text-sm text-gray-500">Prochain RDV</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
                <div class="bg-green-100 text-green-600 rounded-xl p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $consultations->count() }}</p>
                    <p class="text-sm text-gray-500">Consultations</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
                <div class="bg-yellow-100 text-yellow-600 rounded-xl p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $rdvEnAttente ? 1 : 0 }}</p>
                    <p class="text-sm text-gray-500">RDV en attente</p>
                </div>
            </div>
        </div>

        <!-- Prochain RDV + Consultations récentes -->
        <div class="grid grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-base font-semibold text-gray-800 mb-4">Prochain Rendez-vous</h2>
                @if($prochainRendezVous)
                    <div class="flex items-center gap-4 p-4 bg-blue-50 rounded-xl">
                        <div class="bg-blue-600 text-white rounded-xl p-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800 text-sm">Dr. {{ $prochainRendezVous->medecin->user->nom }}</p>
                            <p class="text-xs text-blue-600 font-medium mt-1">{{ $prochainRendezVous->date_heure }}</p>
                            <p class="text-xs text-gray-500">{{ $prochainRendezVous->motif }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-sm text-gray-400">Aucun rendez-vous prévu.</p>
                @endif
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-base font-semibold text-gray-800 mb-4">Consultations Récentes</h2>
                @forelse($consultations->take(3) as $consultation)
                    <div class="flex justify-between py-2 border-b border-gray-100">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $consultation->diagnostic }}</p>
                            <p class="text-xs text-gray-500">Dr. {{ $consultation->rendezVous->medecin->user->nom }}</p>
                        </div>
                        <span class="text-xs text-gray-500">{{ $consultation->date }}</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-400">Aucune consultation récente.</p>
                @endforelse
            </div>
        </div>
        </div>  
        </x-app-layout>
