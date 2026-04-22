<x-app-layout>
<div class="max-w-7xl mx-auto py-8">


        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Prendre un Rendez-vous</h1>
            <a href="{{ route('patient.rendezvous') }}" class="text-blue-600 hover:underline text-sm">← Retour</a>
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

        <div class="bg-white rounded-xl shadow p-8 max-w-2xl">

            <!-- Informations -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                <h3 class="text-sm font-semibold text-blue-700 mb-3">ℹ️ Informations importantes</h3>
                <ul class="space-y-2 text-sm text-blue-600">
                    <li class="flex items-center gap-2">
                        <span>⏰</span> Veuillez arriver 10 minutes avant votre rendez-vous
                    </li>
                    <li class="flex items-center gap-2">
                        <span>💳</span> Pensez à apporter votre carte vitale et votre carte de mutuelle
                    </li>
                    <li class="flex items-center gap-2">
                        <span>📧</span> Vous recevrez une confirmation par email 
                    </li>
                </ul>
            </div>
            <form action="{{ route('patient.rendezvous.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Médecin</label>
                    <select name="medecin_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">-- Sélectionner un médecin --</option>
                        @foreach($medecins as $medecin)
                            <option value="{{ $medecin->id }}" {{ old('medecin_id') == $medecin->id ? 'selected' : '' }}>
                                Dr. {{ $medecin->user->nom }} {{ $medecin->user->prenom }} — {{ $medecin->specialite }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date & Heure</label>
                    <input type="datetime-local" name="date_heure" value="{{ old('date_heure') }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Motif</label>
                    <input type="text" name="motif" value="{{ old('motif') }}" required
                        placeholder="Ex: Consultation générale, douleur..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <input type="text" value="En attente" disabled
                        class="w-full border border-gray-200 rounded-lg px-4 py-2 text-sm bg-gray-50 text-gray-400 cursor-not-allowed">
                    <p class="text-xs text-gray-400 mt-1">Le statut est défini automatiquement</p>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-medium transition">
                    Confirmer le Rendez-vous
                </button>
            </form>
        </div>

</div >
</x-app-layout>
