<x-app-layout>
    <div class="flex flex-col md:flex-row items-center justify-between mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-800">Gestion des Patients</h2>
            <p class="text-sm text-gray-500 mt-1">Consultez et gérez la base de données de vos patients.</p>
        </div>

        <a href="{{ route('patients.create') }}"
           class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl transition-all shadow-sm hover:shadow-md active:scale-95">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            Nouveau Patient
        </a>
    </div>

    <div class="relative mb-6">
        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </span>
        <input type="text" id="search" placeholder="Rechercher par nom, CIN ou email..."
            class="w-full bg-white border border-gray-200 rounded-2xl pl-10 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent shadow-sm transition-all">
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse" id="patientsTable">
                <thead class="bg-gray-50/50 border-b border-gray-100 text-gray-400 uppercase text-[11px] font-black tracking-widest">
                    <tr>
                        <th class="px-6 py-5">Patient & Coordonnées</th>
                        <th class="px-6 py-5">Contact</th>
                        <th class="px-6 py-5">Naissance</th>
                        <th class="px-6 py-5 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50" id="patientsBody">
                    @forelse($patients as $patient)
                    <tr class="group hover:bg-green-50/30 transition-all duration-200 patient-row">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold text-xs shadow-inner uppercase">
                                    {{ strtoupper(substr($patient->user->nom, 0, 1)) }}{{ strtoupper(substr($patient->user->prenom, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 group-hover:text-green-700 transition">
                                        {{ $patient->user->nom }} {{ $patient->user->prenom }}
                                    </div>
                                    <div class="text-[10px] text-gray-400 font-mono tracking-tighter">
                                        CIN: {{ $patient->cin ?? 'Non spécifié' }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-1">
                                <span class="text-xs text-gray-600 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    {{ $patient->user->email }}
                                </span>
                                <span class="text-xs text-gray-500 flex items-center gap-1 font-medium">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    {{ $patient->telephone }}
                                </span>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <span class="text-xs font-semibold text-gray-600 bg-gray-100 px-2 py-1 rounded-md">
                                {{ \Carbon\Carbon::parse($patient->date_naissance)->format('d/m/Y') }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('patients.edit', $patient->id) }}" 
                                   class="p-2 text-amber-500 hover:bg-amber-50 rounded-xl transition-all hover:scale-110" 
                                   title="Modifier le patient">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                </a>

                                <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Supprimer ce patient ?')" 
                                            class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all hover:scale-110" 
                                            title="Supprimer">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="emptyRow">
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="bg-gray-50 p-4 rounded-full mb-4">
                                    <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <p class="text-gray-400 font-medium">Aucun patient dans la liste.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div id="noResult" class="hidden px-6 py-20 text-center">
            <div class="flex flex-col items-center">
                <svg class="w-12 h-12 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <p class="text-gray-400 font-medium text-base">Aucun patient ne correspond à votre recherche.</p>
            </div>
        </div>

        <div class="bg-gray-50/50 px-6 py-4 border-t border-gray-100 flex justify-between items-center text-[10px] text-gray-400 font-bold uppercase tracking-widest">
            <span>Total: <span id="totalCount">{{ $patients->count() }}</span> Patients</span>
            <span>Atlas Coding Management</span>
        </div>
    </div>

    <script>
        document.getElementById('search').addEventListener('input', function () {
            const query = this.value.toLowerCase();
            const rows  = document.querySelectorAll('.patient-row');
            let found   = 0;

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                if (text.includes(query)) {
                    row.style.display = '';
                    found++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Update visible counts and table visibility
            document.getElementById('noResult').classList.toggle('hidden', found > 0);
            document.getElementById('patientsTable').classList.toggle('hidden', found === 0 && query !== '');
            
            // Note: If query is empty, show empty state if initial count was 0
            if (query === '' && {{ $patients->count() }} === 0) {
                document.getElementById('patientsTable').classList.remove('hidden');
            }
        });
    </script>
</x-app-layout>