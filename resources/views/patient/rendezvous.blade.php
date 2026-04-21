<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Rendez-vous</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    @include('patient.sidebar')

    <main class="flex-1 ml-64 p-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Mes Rendez-vous</h1>
        </div>

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-blue-50 text-blue-700 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">Date & Heure</th>
                        <th class="px-6 py-4">Médecin</th>
                        <th class="px-6 py-4">Motif</th>
                        <th class="px-6 py-4">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($rendezVous as $rdv)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-800">{{ \Carbon\Carbon::parse($rdv->date_heure)->format('d/m/Y à H:i') }}</td>
                        <td class="px-6 py-4 text-gray-600">Dr. {{ $rdv->medecin->user->nom }} {{ $rdv->medecin->user->prenom }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $rdv->motif }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ $rdv->statut == 'confirme' ? 'bg-green-100 text-green-700' :
                                   ($rdv->statut == 'annule' ? 'bg-red-100 text-red-700' :
                                   'bg-yellow-100 text-yellow-700') }}">
                                {{ $rdv->statut == 'confirme' ? 'Confirmé' : ($rdv->statut == 'annule' ? 'Annulé' : 'En attente') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">Aucun rendez-vous trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
