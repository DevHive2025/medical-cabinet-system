<x-app-layout>
<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-gray-800">
        @if(auth()->user()->role === 'secretaire')
            Planning du jour ({{ now()->format('d/m/Y') }})
        @else
            Mes Rendez-vous
        @endif
    </h2>

    <a href="{{ route('rendez-vous.create') }}"
       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
        + Nouveau Rendez-vous
    </a>
</div>

<div class="mb-4">
    <input type="text" id="search" placeholder="Rechercher par patient, médecin ou statut..."
        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm text-left" id="rdvTable">

        <thead class="bg-green-50 text-green-700 uppercase text-xs">
            <tr>
                <th class="px-6 py-4">Date & Heure</th>
                
                @if(auth()->user()->role === 'secretaire')
                    <th class="px-6 py-4">Patient</th>
                @endif
                
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

                @if(auth()->user()->role === 'secretaire')
                    <td class="px-6 py-4 font-medium text-gray-800">
                        {{ $rdv->patient->user->nom ?? '' }}
                        {{ $rdv->patient->user->prenom ?? '' }}
                    </td>
                @endif

                <td class="px-6 py-4 text-gray-600">
                    Dr. {{ $rdv->medecin->user->nom ?? 'Inconnu' }}
                </td>

                <td class="px-6 py-4">
                    @if(strtolower($rdv->statut) == 'termine' || strtolower($rdv->statut) == 'termine')
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-medium">
                            Terminé
                        </span>
                    @elseif(strtolower($rdv->statut) == 'annule' || strtolower($rdv->statut) == 'annule')
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-medium">
                            Annulé
                        </span>
                    @elseif(strtolower($rdv->statut) == 'confirme' || strtolower($rdv->statut) == 'confirme')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium">
                            Confirmé
                        </span>
                    @else
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-medium">
                            En attente
                        </span>
                    @endif
                </td>

                <td class="px-6 py-4 flex items-center gap-2">

                    @if(strtolower($rdv->statut) != 'annule')
                        <a href="{{ route('rendez-vous.edit', $rdv->id) }}"
                           class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-3 py-1 rounded text-xs font-medium transition">
                            Modifier
                        </a>

                        <form action="{{ route('rendez-vous.annuler', $rdv->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler ce rendez-vous ?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded text-xs font-medium transition">
                                Annuler
                            </button>
                        </form>
                    @endif
                    @if(auth()->user()->role === 'secretaire'&& strtolower($rdv->statut) == 'en_attente')
                        <form action="{{ route('rendez-vous.Sconfirmer', $rdv->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler ce rendez-vous ?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                class="bg-green-100 hover:bg-green-200 text-green-700 px-3 py-1 rounded text-xs font-medium transition">
                                Confirmer
                            </button>
                        </form>
                    @endif

                </td>

            </tr>
            @empty
            <tr>
                <td colspan="100%" class="px-6 py-8 text-center text-gray-400">
                    Aucun rendez-vous trouvé.
                </td>
            </tr>
            @endforelse

        </tbody>

    </table>

    <div id="noResult" class="hidden px-6 py-8 text-center text-gray-400">
        Aucun rendez-vous trouvé pour cette recherche.
    </div>

</div>

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