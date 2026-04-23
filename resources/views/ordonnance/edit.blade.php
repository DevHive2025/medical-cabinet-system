<x-app-layout>
<div class="max-w-7xl mx-auto py-8">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Modifier l'Ordonnance</h1>
        <a href="{{ route('ordonnance.show', $ordonnance->id) }}" class="text-green-600 hover:underline text-sm">← Retour</a>
    </div>

    <div class="bg-blue-50 rounded-xl p-4 mb-6">
        <p class="font-semibold text-gray-800">Réf: {{ $ordonnance->reference }}</p>
        <p class="text-sm text-gray-500">{{ $ordonnance->date_ordonnance }}</p>
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
        <form action="{{ route('ordonnance.update', $ordonnance->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-4 gap-3 mb-2 px-1">
                <p class="text-xs font-semibold text-gray-500 uppercase">Médicament</p>
                <p class="text-xs font-semibold text-gray-500 uppercase">Dose</p>
                <p class="text-xs font-semibold text-gray-500 uppercase">Posologie</p>
                <p class="text-xs font-semibold text-gray-500 uppercase">Durée</p>
            </div>

            <div id="lignes_container">
                @foreach($ordonnance->lignes as $i => $ligne)
                <div class="grid grid-cols-4 gap-3 mb-3 ligne-row">
                    <input type="text" name="lignes[{{ $i }}][medicament]" value="{{ $ligne->medicament }}" required
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    <input type="text" name="lignes[{{ $i }}][dose]" value="{{ $ligne->dose }}"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    <input type="text" name="lignes[{{ $i }}][posologie]" value="{{ $ligne->posologie }}"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                    <div class="flex gap-2">
                        <input type="text" name="lignes[{{ $i }}][duree]" value="{{ $ligne->duree }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                        <button type="button" onclick="this.closest('.ligne-row').remove()"
                            class="bg-red-100 text-red-600 px-3 rounded-lg text-sm font-bold">✕</button>
                    </div>
                </div>
                @endforeach
            </div>

            <button type="button" onclick="ajouterLigne()" class="mb-6 text-sm text-green-600 hover:underline font-medium">
                + Ajouter un médicament
            </button>

            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg font-medium transition">
                Mettre à jour
            </button>
        </form>
    </div>
</div>
</x-app-layout>

<script>
    let index = {{ $ordonnance->lignes->count() }};
    function ajouterLigne() {
        const container = document.getElementById('lignes_container');
        const div = document.createElement('div');
        div.className = 'grid grid-cols-4 gap-3 mb-3 ligne-row';
        div.innerHTML = `
            <input type="text" name="lignes[${index}][medicament]" required placeholder="Ex: Amoxicilline"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
            <input type="text" name="lignes[${index}][dose]" placeholder="Ex: 1g"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
            <input type="text" name="lignes[${index}][posologie]" placeholder="Ex: 2 fois/jour"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
            <div class="flex gap-2">
                <input type="text" name="lignes[${index}][duree]" placeholder="Ex: 5 jours"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                <button type="button" onclick="this.closest('.ligne-row').remove()"
                    class="bg-red-100 text-red-600 px-3 rounded-lg text-sm font-bold">✕</button>
            </div>
        `;
        container.appendChild(div);
        index++;
    }
</script>
