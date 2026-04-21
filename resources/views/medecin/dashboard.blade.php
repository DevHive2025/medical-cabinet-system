<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Médecin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    @include('medecin.sidebar')

    <main class="flex-1 ml-64 p-8">

        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Bonjour, Dr. {{ auth()->user()->prenom }} 👋</h1>
                <p class="text-sm text-gray-500 mt-1">Voici un aperçu de votre activité aujourd'hui</p>
            </div>
            <div class="text-sm text-gray-500 bg-white px-4 py-2 rounded-lg shadow">
                📅 {{ now()->format('d/m/Y') }}
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
                <div class="bg-green-100 text-green-600 rounded-xl p-3">
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

            <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
                <div class="bg-yellow-100 text-yellow-600 rounded-xl p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $rdvAujourdhui }}</p>
                    <p class="text-sm text-gray-500">RDV aujourd'hui</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-6">

            <!-- Prochains RDV -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-base font-semibold text-gray-800 mb-4">Prochains Rendez-vous</h2>
                <div class="space-y-3">
                    @forelse($prochainRdv as $rdv)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $rdv->patient->user->nom }} {{ $rdv->patient->user->prenom }}</p>
                            <p class="text-xs text-gray-500">{{ $rdv->date_heure }} — {{ $rdv->motif }}</p>
                        </div>
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $rdv->statut == 'confirmé' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $rdv->statut }}
                        </span>
                    </div>
                    @empty
                    <p class="text-sm text-gray-400">Aucun rendez-vous prévu.</p>
                    @endforelse
                </div>
            </div>

            <!-- Dernières Consultations -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-base font-semibold text-gray-800 mb-4">Dernières Consultations</h2>
                <div class="space-y-3">
                    @forelse($dernieresConsultations as $consultation)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $consultation->rendezVous->patient->user->nom }} {{ $consultation->rendezVous->patient->user->prenom }}</p>
                            <p class="text-xs text-gray-500">{{ $consultation->diagnostic }}</p>
                        </div>
                        <span class="text-xs text-gray-500">{{ $consultation->date }}</span>
                    </div>
                    @empty
                    <p class="text-sm text-gray-400">Aucune consultation récente.</p>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- RDV en attente -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-base font-semibold text-gray-800 mb-4">
                Rendez-vous en attente
                @if($rdvEnAttente->count() > 0)
                    <span class="ml-2 bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">{{ $rdvEnAttente->count() }}</span>
                @endif
            </h2>
            <table class="w-full text-sm text-left">
                <thead class="bg-yellow-50 text-yellow-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Patient</th>
                        <th class="px-4 py-3">Date & Heure</th>
                        <th class="px-4 py-3">Motif</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($rdvEnAttente as $rdv)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $rdv->patient->user->nom }} {{ $rdv->patient->user->prenom }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $rdv->date_heure }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $rdv->motif }}</td>
                        <td class="px-4 py-3 flex gap-2">
                            <form action="{{ route('medecin.rendezvous.annuler', $rdv->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded text-xs font-medium transition">
                                    Annuler
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-400">Aucun rendez-vous en attente.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Historique des consultations -->
        <div class="bg-white rounded-xl shadow p-6 mt-6">
            <h2 class="text-base font-semibold text-gray-800 mb-4">📋 Historique des Consultations</h2>
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-400 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Patient</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Diagnostic</th>
                        <th class="px-4 py-3">Symptômes</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($dernieresConsultations as $consultation)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-800">
                            {{ $consultation->rendezVous->patient->user->nom }} {{ $consultation->rendezVous->patient->user->prenom }}
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $consultation->date }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $consultation->diagnostic }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ Str::limit($consultation->symptomes, 40) }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('consultation.show', $consultation->id) }}"
                               class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded text-xs font-medium transition">
                                Voir
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-400">Aucune consultation.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </main>

</body>
</html>
