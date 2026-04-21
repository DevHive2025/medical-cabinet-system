<x-admin-layout>
<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-3xl mx-auto">
        
        @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('success') }}
    </div>
@endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Ajouter un nouvel utilisateur</h1>
            <p class="text-gray-600">Complétez les informations pour créer un compte membre ou patient.</p>
        </div>

        <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informations de base</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nom</label>
                        <input type="text" name="nom" value="{{ old('nom') }}" required
                            class="mt-1 block w-full rounded-md shadow-sm @error('nom') border-red-500 @else border-gray-300 @enderror focus:ring-indigo-500">
                        @error('nom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prénom</label>
                        <input type="text" name="prenom" value="{{ old('prenom') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Adresse Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500">
                    </div>
                </div>
                <div class="mt-4 p-3 bg-indigo-50 rounded-lg">
                    <p class="text-xs text-indigo-700 italic">
                        💡 Le mot de passe sera généré automatiquement (Ex: Nom@2026).
                    </p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Rôle & Permissions</h2>
                <select name="role" id="role-select" onchange="toggleFields()" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500">
                    <option value="">-- Choisir un rôle --</option>
                    <option value="medecin" {{ old('role') == 'medecin' ? 'selected' : '' }}>Médecin</option>
                    <option value="secretaire" {{ old('role') == 'secretaire' ? 'selected' : '' }}>Secrétaire</option>
                    <option value="patient" {{ old('role') == 'patient' ? 'selected' : '' }}>Patient</option>
                </select>
            </div>

            <div id="fields-medecin" class="hidden bg-blue-50 p-6 rounded-xl border border-blue-200">
                <h2 class="text-lg font-semibold text-blue-800 mb-4">Détails Médecin</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="specialite" placeholder="Spécialité (ex: Cardiologie)" class="rounded-md border-gray-300">
                    <input type="text" name="cabinet_telephone" placeholder="Téléphone Cabinet" class="rounded-md border-gray-300">
                </div>
            </div>

            <div id="fields-patient" class="hidden bg-green-50 p-6 rounded-xl border border-green-200">
                <h2 class="text-lg font-semibold text-green-800 mb-4">Détails Patient</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="cin" placeholder="CIN" class="rounded-md border-gray-300">
                    <select name="genre" class="rounded-md border-gray-300">
                        <option value="Homme">Homme</option>
                        <option value="Femme">Femme</option>
                    </select>
                    <input type="date" name="date_naissance" class="rounded-md border-gray-300">
                    <input type="text" name="telephone" placeholder="Téléphone Mobile" class="rounded-md border-gray-300">
                </div>
            </div>

            <div id="fields-secretaire" class="hidden bg-purple-50 p-6 rounded-xl border border-purple-200">
                <h2 class="text-lg font-semibold text-purple-800 mb-4">Détails Secrétaire</h2>
                <input type="text" name="bureau" placeholder="Numéro de bureau ou poste" class="w-full rounded-md border-gray-300">
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('users.index') }}" class="px-5 py-2.5 border border-gray-300 rounded-xl text-gray-700 bg-white hover:bg-gray-50 transition">Annuler</a>
                <button type="submit" class="flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-indigo-500 to-purple-500 hover:opacity-90 shadow-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Enregistrer l'utilisateur
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleFields() {
        const role = document.getElementById('role-select').value;
        const groups = ['fields-medecin', 'fields-patient', 'fields-secretaire'];
        
        // Masquer tout
        groups.forEach(id => {
            document.getElementById(id).classList.add('hidden');
        });

        // Afficher la section correspondante
        if (role && document.getElementById('fields-' + role)) {
            document.getElementById('fields-' + role).classList.remove('hidden');
        }
    }
    // Lancer au chargement pour garder les champs affichés en cas d'erreur de validation
    window.onload = toggleFields;
</script>
</x-admin-layout>