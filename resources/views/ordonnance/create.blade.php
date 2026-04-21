<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Ordonnance</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    @include('medecin.sidebar')

    <main class="flex-1 ml-64 p-8">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Créer une Ordonnance</h1>
            <a href="{{ route('medecin.consultations') }}" class="text-green-600 hover:underline text-sm">← Retour</a>
        </div>

        <!-- Infos Patient -->
        <div class="bg-blue-50 rounded-xl p-4 mb-6 flex items-center gap-4">
            <div class="bg-blue-600 text-white rounded-xl p-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-gray-800">{{ $consultation->rendezVous->patient->user->nom }} {{ $consultation->rendezVous->patient->user->prenom }}</p>
                <p class="text-sm text-gray-500">Consultation du {{ $consultation->date }} — {{ $consultation->diagnostic }}</p>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow p-8">
            <form action="{{ route('ordonnance.store', $consultation->id) }}" method="POST" id="ordonnanceForm">
                @csrf

                <div id="medicaments">
                    <div class="grid grid-cols-4 gap-4 mb-4 medicament-row">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Médicament</label>
                            <input type="text" name="medicaments[]" required placeholder="Ex: Paracétamol 500mg"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dose</label>
                            <input type="text" name="dose[]" required placeholder="Ex: 150 mg"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Posologie</label>
                            <input type="text" name="posologie[]" required placeholder="Ex: 1 comprimé 3x/jour"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Durée</label>
                            <input type="text" name="duree[]" required placeholder="Ex: 7 jours"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                        </div>
                    </div>
                </div>

                <button type="button" onclick="ajouterMedicament()"
                    class="mb-6 text-sm text-green-600 hover:underline font-medium">
                    + Ajouter un médicament
                </button>

                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-medium transition">
                    Créer l'Ordonnance
                </button>
            </form>
        </div>

    </main>

    <script>
        function ajouterMedicament() {
            const div = document.createElement('div');
            div.className = 'grid grid-cols-4 gap-4 mb-4 medicament-row';
            div.innerHTML = `
                <div>
                    <input type="text" name="medicaments[]" required placeholder="Ex: Amoxicilline 500mg"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>
                <div>
                    <input type="text" name="dose[]" required placeholder="Ex: 1 gélule 2x/jour"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>
                <div>
                    <input type="text" name="posologie[]" required placeholder="Ex: 1 gélule 2x/jour"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>
                <div class="flex gap-2">
                    <input type="text" name="duree[]" required placeholder="Ex: 5 jours"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    <button type="button" onclick="this.closest('.medicament-row').remove()"
                        class="bg-red-100 text-red-600 px-3 rounded-lg text-sm">✕</button>
                </div>
            `;
            document.getElementById('medicaments').appendChild(div);
        }
    </script>

</body>
</html>
