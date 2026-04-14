<x-app-layout>

<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Liste des Rendez-vous</h2>

    <a href="{{ route('rendez-vous.create') }}"
       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
        + Nouveau Rendez-vous
    </a>
</div>

<!-- Search -->
<div class="mb-4">
    <input type="text" id="search" placeholder="Rechercher par patient, médecin ou statut..."
        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm text-left" id="rdvTable">

        <thead class="bg-green-50 text-green-700 uppercase text-xs">
            <tr>
                <th class="px-6 py-4">Date & Heure</th>
                <th class="px-6 py-4">Patient</th>
                <th class="px-6 py-4">Médecin</th>
                <th class="px-6 py-4">Statut</th>
                <th class="px-6 py-4">Actions</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">

            @forelse($rdvs as $rdv)
            <tr class="hover:bg-gray-50 transition rdv-row">

                <td class="px-6 py-4 text-gray-700">
                    {{ \Carbon\Carbon::parse($rdv->date_heure)->format('d/m/Y H:i') }}
                </td>

                <td class="px-6 py-4 font-medium text-gray-800">
                    {{ $rdv->patient->user->nom ?? '' }}
                    {{ $rdv->patient->user->prenom ?? '' }}
                </td>

                <td class="px-6 py-4 text-gray-600">
                    Dr. {{ $rdv->medecin->nom ?? $rdv->medecin->name ?? 'Inconnu' }}
                </td>

                <td class="px-6 py-4">
                    @if($rdv->statut == 'confirmé')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium">
                            Confirmé
                        </span>
                    @elseif($rdv->statut == 'annulé')
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-medium">
                            Annulé
                        </span>
                    @else
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-medium">
                            En attente
                        </span>
                    @endif
                </td>

                <td class="px-6 py-4 flex items-center gap-2">

                    <a href="{{ route('rendez-vous.edit', $rdv->id) }}"
                       class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-3 py-1 rounded text-xs font-medium transition">
                        Modifier
                    </a>

                    @if($rdv->statut != 'annulé')
                    <form action="{{ route('rendez-vous.annuler', $rdv->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <button type="submit"
                            onclick="return confirm('Voulez-vous vraiment annuler ce rendez-vous ?')"
                            class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded text-xs font-medium transition">
                            Annuler
                        </button>
                    </form>
                    @endif

                </td>

            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                    Aucun rendez-vous trouvé.
                </td>
            </tr>
            @endforelse

        </tbody>

    </table>

    <!-- No result message -->
    <div id="noResult" class="hidden px-6 py-8 text-center text-gray-400">
        Aucun rendez-vous trouvé pour cette recherche.
    </div>

</div>

<!-- SEARCH SCRIPT -->
<script>
document.getElementById('search').addEventListener('input', function () {
    const query = this.value.toLowerCase();
    const rows = document.querySelectorAll('.rdv-row');
    let found = 0;

    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        if (text.includes(query)) {
            row.style.display = '';
            found++;
        } else {
            row.style.display = 'none';
        }
    });

    document.getElementById('noResult').classList.toggle('hidden', found > 0);
});
</script>

</x-app-layout>