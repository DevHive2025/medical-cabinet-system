<x-app-layout>
    <div class="max-w-3xl mx-auto">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Modifier le Rendez-vous</h2>
            <a href="{{ route('rendez-vous.index') }}"
               class="text-sm text-gray-600 hover:text-gray-900">
                ← Retour
            </a>
        </div>

        <form action="{{ route('rendez-vous.update', $rdv->id) }}" method="POST"
              class="bg-white rounded-xl shadow p-6 space-y-5">
            @csrf
            @method('PUT')

            <!-- Date & Heure -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date et Heure</label>
                <input type="datetime-local" name="date_heure"
                       value="{{ \Carbon\Carbon::parse($rdv->date_heure)->format('Y-m-d\TH:i') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400"
                       required>
            </div>

            <!-- Statut -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select name="statut"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400"
                        required>
                    <option value="en_attente" {{ $rdv->statut == 'en_attente' ? 'selected' : '' }}>
                        En attente
                    </option>
                    <option value="confirme" {{ $rdv->statut == 'confirme' ? 'selected' : '' }}>
                        Confirmé
                    </option>
                    <option value="annule" {{ $rdv->statut == 'annule' ? 'selected' : '' }}>
                        Annulé
                    </option>
                    <option value="termine" {{ $rdv->statut == 'termine' ? 'selected' : '' }}>
                        Terminé
                    </option>
                </select>
            </div>

            <!-- Motif -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Motif</label>
                <textarea name="motif" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400">{{ $rdv->motif }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition">
                    Mettre à jour
                </button>

                <a href="{{ route('rendez-vous.index') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-medium transition">
                    Retour
                </a>
            </div>

        </form>
    </div>
</x-app-layout>