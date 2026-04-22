<x-app-layout>
<div class="max-w-7xl mx-auto py-8">

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded">{{ session('success') }}</div>
        @endif

        <h1 class="text-2xl font-bold text-gray-800 mb-6">Mes Rendez-vous</h1>

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full text-sm text-left">
                <thead class="bg-green-50 text-green-700 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">Patient</th>
                        <th class="px-6 py-4">Date & Heure</th>
                        <th class="px-6 py-4">Motif</th>
                        <th class="px-6 py-4">Statut</th>
                        <th class="px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($rendezVous as $rdv)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $rdv->patient->user->nom }} {{ $rdv->patient->user->prenom }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $rdv->date_heure }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $rdv->motif }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ $rdv->statut == 'confirme' ? 'bg-green-100 text-green-700' :
                                   ($rdv->statut == 'annule' ? 'bg-red-100 text-red-700' :
                                   ($rdv->statut == 'termine' ? 'bg-gray-100 text-gray-700' :
                                   'bg-yellow-100 text-yellow-700')) }}">
                                {{ $rdv->statut }}
                            </span>
                        </td>
                        <td class="px-6 py-4 flex items-center gap-2">
                            @if($rdv->statut == 'en_attente')
                                <form action="{{ route('medecin.rendezvous.annuler', $rdv->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded text-xs font-medium transition">Annuler</button>
                                </form>
                            @endif

                            @if($rdv->statut == 'confirme' && !$rdv->consultation)
                                <a href="{{ route('medecin.consultation.create', $rdv->id) }}"
                                   class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded text-xs font-medium transition">
                                    + Consultation
                                </a>
                            @endif
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
</x-app-layout>

