<x-app-layout>
    <div class="max-w-4xl mx-auto">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Prendre un nouveau Rendez-vous</h2>
            <a href="{{ route('rendez-vous.index') }}"
               class="text-sm text-gray-600 hover:text-gray-900">
                ← Retour
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded-lg text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('rendez-vous.store') }}" method="POST"
              class="bg-white rounded-xl shadow p-6 space-y-5">
            @csrf

            <!-- Patient -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Patient</label>
                <select name="patient_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400"
                        required>
                    <option value="">Sélectionnez un patient</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">
                            {{ $patient->user->nom }} {{ $patient->user->prenom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Médecin -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Médecin</label>
                <select name="medecin_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400"
                        required>
                    <option value="">Sélectionnez un médecin</option>
                    @foreach($medecins as $medecin)
                        <option value="{{ $medecin->id }}">
                            Dr. {{ $medecin->user->nom ?? $medecin->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date et Heure</label>
                <input type="datetime-local" name="date_heure"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400"
                       required>
            </div>

            <!-- Motif -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Motif (Optionnel)</label>
                <textarea name="motif" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition">
                    Enregistrer
                </button>

                <a href="{{ route('rendez-vous.index') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-medium transition">
                    Annuler
                </a>
            </div>

        </form>
    </div>
</x-app-layout>