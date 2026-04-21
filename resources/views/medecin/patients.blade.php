<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Patients</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    @include('medecin.sidebar')

    <main class="flex-1 ml-64 p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Mes Patients</h1>

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-green-50 text-green-700 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">Nom</th>
                        <th class="px-6 py-4">Prénom</th>
                        <th class="px-6 py-4">Téléphone</th>
                        <th class="px-6 py-4">Date de naissance</th>
                        <th class="px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($patients as $patient)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $patient->user->nom }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $patient->user->prenom }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $patient->telephone }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $patient->date_naissance }}</td>
                        <td class="px-6 py-4">
                            @if($patient->dossierMedical)
                                <a href="{{ route('medecin.dossier', $patient->dossierMedical->id) }}"
                                   class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded text-xs font-medium transition">
                                    Voir Dossier
                                </a>
                            @else
                                <span class="text-xs text-gray-400">Pas de dossier</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Aucun patient trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
