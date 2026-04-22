<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            {{ auth()->user()->role === 'secretaire' ? "Planning du jour" : "Mes Rendez-vous" }}
        </h2>
        <a href="{{ route('rendez-vous.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
            + Nouveau Rendez-vous
        </a>
    </div>

    <div class="mb-4">
        <input type="text" id="search" placeholder="Rechercher..." class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-green-400">
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm text-left" id="rdvTable">
            <thead class="bg-green-50 text-green-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Date & Heure</th>
                    @if(auth()->user()->role === 'secretaire') <th class="px-6 py-4">Patient</th> @endif
                    <th class="px-6 py-4">Médecin</th>
                    <th class="px-6 py-4">Statut</th>
                    <th class="px-6 py-4">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($rdvs as $rdv)
                <tr class="hover:bg-gray-50 transition rdv-row">
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($rdv->date_heure)->format('d/m/Y H:i') }}</td>
                    
                    @if(auth()->user()->role === 'secretaire')
                        <td class="px-6 py-4 font-medium">{{ $rdv->patient->user->nom ?? '' }} {{ $rdv->patient->user->prenom ?? '' }}</td>
                    @endif

                    <td class="px-6 py-4">Dr. {{ $rdv->medecin->user->nom ?? '' }}</td>

                    <td class="px-6 py-4">
                        @php
                            $colors = [
                                'confirme' => 'bg-green-100 text-green-700',
                                'annule' => 'bg-red-100 text-red-700',
                                'termine' => 'bg-blue-100 text-blue-700',
                                'en_attente' => 'bg-yellow-100 text-yellow-700'
                            ];
                            $status = strtolower($rdv->statut);
                        @endphp
                        <span class="{{ $colors[$status] ?? 'bg-gray-100' }} px-3 py-1 rounded-full text-xs font-medium">
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </span>
                    </td>

                    <td class="px-6 py-4 flex items-center gap-2">
                        <a href="{{ route('rendez-vous.edit', $rdv->id) }}" class="text-yellow-600 hover:underline text-xs">Modifier</a>
                        
                        @if(auth()->user()->role === 'secretaire')
                        <form action="{{ route('rendez-vous.status', $rdv->id) }}" method="POST" class="flex gap-1">
                            @csrf @method('PATCH')
                            <select name="statut" class="text-xs border rounded">
                                <option value="confirme">Confirmer</option>
                                <option value="annule">Annuler</option>
                                <option value="termine">Terminer</option>
                            </select>
                            <button class="bg-blue-500 text-white px-2 py-1 rounded text-xs">OK</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-10 text-gray-400">Aucun rendez-vous.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>