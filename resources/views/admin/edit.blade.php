<x-admin-layout>
    <div class="max-w-4xl mx-auto py-10 px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Modifier le profil</h1>
                <p class="text-gray-500 text-sm italic">Mise à jour des informations de {{ $user->nom }} {{ $user->prenom }}</p>
            </div>
            <a href="{{ route('users.index') }}" class="flex items-center text-gray-400 hover:text-indigo-600 transition group font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Retour
            </a>
        </div>

        <form action="{{ route('users.update', $user->id) }}" method="POST" class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
            @csrf
            @method('PUT')

            <div class="p-8 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Nom</label>
                        <input type="text" name="nom" value="{{ old('nom', $user->nom) }}" class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition outline-none" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Prénom</label>
                        <input type="text" name="prenom" value="{{ old('prenom', $user->prenom) }}" class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition outline-none" required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition outline-none" required>
                    </div>

                    

                    <div id="fields_medecin" class="role-fields md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 {{ $user->role !== 'medecin' ? 'hidden' : '' }}">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Spécialité</label>
                            <input type="text" name="specialite" value="{{ optional($user->medecin)->specialite }}" class="w-full px-4 py-3 rounded-xl border border-indigo-100 bg-indigo-50/30 focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Téléphone Cabinet</label>
                            <input type="text" name="cabinet_telephone" value="{{ optional($user->medecin)->cabinet_telephone }}" class="w-full px-4 py-3 rounded-xl border border-indigo-100 bg-indigo-50/30 focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none">
                        </div>
                    </div>

                    <div id="fields_patient" class="role-fields md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 {{ $user->role !== 'patient' ? 'hidden' : '' }}">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">CIN</label>
                            <input type="text" name="cin" value="{{ optional($user->patient)->cin }}" class="w-full px-4 py-3 rounded-xl border border-indigo-100 bg-indigo-50/30 focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Téléphone</label>
                            <input type="text" name="telephone" value="{{ optional($user->patient)->telephone }}" class="w-full px-4 py-3 rounded-xl border border-indigo-100 bg-indigo-50/30 focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Date de Naissance</label>
                            <input type="date" name="date_naissance" value="{{ optional($user->patient)->date_naissance }}" class="w-full px-4 py-3 rounded-xl border border-indigo-100 bg-indigo-50/30 focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none">
                        </div>
                    </div>

                    <div id="fields_secretaire" class="role-fields md:col-span-2 {{ $user->role !== 'secretaire' ? 'hidden' : '' }}">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Bureau / Numéro de Poste</label>
                        <input type="text" name="bureau" value="{{ optional($user->secretaire)->bureau }}" class="w-full px-4 py-3 rounded-xl border border-indigo-100 bg-indigo-50/30 focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-50 flex justify-end items-center gap-3">
                    <button type="reset" class="px-6 py-3 rounded-xl text-gray-400 hover:text-gray-600 font-semibold transition">
                        Annuler
                    </button>
                    <button type="submit" class="px-10 py-3 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all transform active:scale-95">
                        Enregistrer les modifications
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('roleSelect').addEventListener('change', function() {
            // Hider ga3 les sections dyal les roles
            document.querySelectorAll('.role-fields').forEach(div => {
                div.classList.add('hidden');
            });

            // Afficher dik li t'khtarat
            const selectedRole = this.value;
            const targetDiv = document.getElementById('fields_' + selectedRole);
            if (targetDiv) {
                targetDiv.classList.remove('hidden');
            }
        });
    </script>
</x-admin-layout>