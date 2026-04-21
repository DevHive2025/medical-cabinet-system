<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dossier Médical</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    @include('medecin.sidebar')

    <main class="flex-1 ml-64 p-8">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Dossier Médical</h1>
            <a href="{{ route('medecin.patients') }}" class="text-green-600 hover:underline text-sm">← Retour</a>
        </div>

        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xl font-bold">
                    {{ strtoupper(substr($dossierMedical->patient->user->nom, 0, 1)) }}
                </div>
                <div class="w-full">
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $dossierMedical->patient->user->nom }} {{ $dossierMedical->patient->user->prenom }}
                    </p>
                    <p class="text-sm text-gray-500 mb-4">{{ $dossierMedical->patient->user->email }}</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
                        <div class="bg-gray-50 rounded-lg px-3 py-2">
                            <span class="text-gray-500">Téléphone :</span>
                            <span class="text-gray-800 font-medium">{{ $dossierMedical->patient->telephone ?? '—' }}</span>
                        </div>
                        <div class="bg-gray-50 rounded-lg px-3 py-2">
                            <span class="text-gray-500">Date naissance :</span>
                            <span class="text-gray-800 font-medium">{{ $dossierMedical->patient->date_naissance ?? '—' }}</span>
                        </div>
                        <div class="bg-gray-50 rounded-lg px-3 py-2">
                            <span class="text-gray-500">Groupe sanguin :</span>
                            <span class="text-gray-800 font-medium">{{ $dossierMedical->groupe_sanguin ?? '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-sm font-semibold text-gray-700 mb-3 uppercase">Maladies Chroniques</h2>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $dossierMedical->maladies_chroniques ?? '—' }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-sm font-semibold text-gray-700 mb-3 uppercase">Antécédents</h2>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $dossierMedical->antecedents ?? '—' }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6 col-span-2">
                <h2 class="text-sm font-semibold text-red-600 mb-3 uppercase">Allergies</h2>
                @if($dossierMedical->allergies)
                    @foreach(explode(',', $dossierMedical->allergies) as $allergie)
                        <span class="bg-red-100 text-red-600 text-sm px-3 py-1 rounded-full mr-2">{{ trim($allergie) }}</span>
                    @endforeach
                @else
                    <p class="text-sm text-gray-400">Aucune allergie.</p>
                @endif
            </div>
        </div>

    </main>

</body>
</html>
