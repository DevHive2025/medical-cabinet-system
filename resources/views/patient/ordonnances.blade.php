<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Ordonnances</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    @include('patient.sidebar')

    <main class="flex-1 ml-64 p-8">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Mes Ordonnances</h1>
            <p class="text-sm text-gray-500 mt-1">Historique de vos ordonnances médicales</p>
        </div>

        @if($ordonnances->isEmpty())
            <div class="bg-white rounded-xl shadow p-12 text-center">
                <div class="text-5xl mb-4">💊</div>
                <p class="text-gray-500 font-medium">Aucune ordonnance trouvée.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($ordonnances as $ordonnance)
                <div class="bg-white rounded-xl shadow p-6">

                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <p class="font-semibold text-gray-800">
                                Dr. {{ $ordonnance->consultation->rendezVous->medecin->user->nom }}
                                {{ $ordonnance->consultation->rendezVous->medecin->user->prenom }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $ordonnance->consultation->rendezVous->medecin->specialite }}
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                                {{ $ordonnance->date_ordonnance }}
                            </span>
                            <a href="{{ route('ordonnance.telecharger', $ordonnance->id) }}"
                               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Télécharger PDF
                            </a>
                        </div>
                    </div>

                    <div class="space-y-2">
                        @foreach($ordonnance->lignes as $ligne)
                        <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $ligne->medicament }}</p>
                                <p class="text-xs text-gray-500">{{ $ligne->posologie }}</p>
                            </div>
                            <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full">{{ $ligne->duree }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-3 text-xs text-gray-400">
                        Réf: {{ $ordonnance->reference }}
                    </div>

                </div>
                @endforeach
            </div>
        @endif

    </main>

</body>
</html>
