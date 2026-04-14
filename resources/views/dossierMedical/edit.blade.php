<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Modifier le Dossier Médical</h2>
        <a href="{{ route('dossierMedical.index') }}" class="text-green-600 hover:underline text-sm flex items-center gap-1">
            <span>←</span> Retour à la liste
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl mx-auto">
        <form action="{{ route('dossierMedical.update', $dossierMedical->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Patient</label>
                <select name="patient_id" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm bg-gray-50 focus:ring-2 focus:ring-green-400 focus:border-transparent transition">
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ old('patient_id', $dossierMedical->patient_id) == $patient->id ? 'selected' : '' }}>
                            {{ $patient->user->nom }} {{ $patient->user->prenom }} ({{ $patient->cin }})
                        </option>
                    @endforeach
                </select>
                @error('patient_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Groupe Sanguin</label>
                <select name="groupe_sanguin" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-400 transition">
                    <option value="">-- Sélectionner --</option>
                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $gs)
                        <option value="{{ $gs }}" {{ old('groupe_sanguin', $dossierMedical->groupe_sanguin) == $gs ? 'selected' : '' }}>
                            {{ $gs }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Maladies Chroniques</label>
                <textarea name="maladies_chroniques" rows="3" placeholder="Ex: Diabète, Hypertension..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-green-400 transition">{{ old('maladies_chroniques', $dossierMedical->maladies_chroniques) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Antécédents Médicaux</label>
                <textarea name="antecedents" rows="3" placeholder="Chirurgies, accidents passés..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-green-400 transition">{{ old('antecedents', $dossierMedical->antecedents) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Allergies</label>
                <textarea name="allergies" rows="3" placeholder="Ex: Pénicilline, Pollen..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-green-400 transition">{{ old('allergies', $dossierMedical->allergies) }}</textarea>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-lg font-bold shadow-md transition-all active:transform active:scale-95">
                    Mettre à jour le Dossier
                </button>
            </div>
        </form>
    </div>
</x-app-layout>