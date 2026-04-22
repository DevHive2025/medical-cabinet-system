<x-app-layout>

<div class="p-1">

    <!-- HEADER -->
    <div class="p-1">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3 text-gray-800 font-semibold text-lg">
            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" d="M12 3l8 4v6c0 5-3.5 9-8 10-4.5-1-8-5-8-10V7l8-4z"/>
            </svg>
            Liste des utilisateurs
        </div>

        <div class="flex items-center gap-3">
            <div class="relative">
                <input type="text"
                       id="js-search-input"
                       placeholder="Rechercher un utilisateur..."
                       class="w-72 pl-10 pr-4 py-2.5 rounded-xl bg-gray-100 border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                <svg class="w-4 h-4 absolute left-3 top-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" d="M21 21l-4.3-4.3m1.8-5.2a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <select id="js-role-filter" 
                    class="flex items-center gap-2 px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                <option value="all">Tous les rôles</option>
                <option value="medecin">Médecin</option>
                <option value="secretaire">Secrétaire</option>
                <option value="patient">Patient</option>
            </select>

            <a href="{{ route('users.create') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r bg-blue-600 hover:opacity-90 transition-all shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Ajouter</span>
            </a>
        </div>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">

        <table class="w-full text-sm">

            <!-- HEAD -->
            <thead class="text-gray-400 text-ms bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left">Nom</th>
                    <th class="px-6 py-4 text-left">Email</th>
                    <th class="px-6 py-4 text-left">Rôle</th>
                    <th class="px-6 py-4 text-left">Créé le</th>
                    <th class="px-6 py-4 text-left">Dernière connexion</th>
                    <th class="px-6 py-4 text-left">Action</th>
                </tr>
            </thead>

            <!-- BODY -->
            <tbody class="divide-y divide-gray-100">

                @foreach($users as $user)
                <tr class="user-row hover:bg-gray-50 transition" data-role="{{ $user->role }}">

                    <!-- nom -->
                    <td class="px-6 py-4 font-medium text-gray-800 whitespace-nowrap">
                        {{ $user->prenom }} {{ $user->nom }} 
                </td>

                    <!-- email -->
                    <td class="px-6 py-4 text-gray-500">
                        {{ $user->email }}
                    </td>

                    <!-- role -->
                    <td class="px-6 py-4">
                        @if($user->role === 'medecin')
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold">
                                Médecin
                            </span>
                        @elseif($user->role === 'secretaire')
                            <span class="px-3 py-1 text-xs rounded-full bg-purple-100 text-purple-700 font-semibold">
                                Secrétaire
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700 font-semibold">
                                Patient
                            </span> 
                        @endif
                    </td>

                    <!-- date -->
                    <td class="px-6 py-4 text-gray-600">
                        {{ $user->created_at->format('d/m/Y') }}
                    </td>

                    <!-- last login -->
                    <td class="px-6 py-4">
                        <div class="flex flex-col justify-center">
                            <div class="flex items-center gap-2">
                                @if($user->isOnline())
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                    </span>
                                    <span class="text-green-600 text-sm font-medium tracking-tight">
                                        En ligne
                                    </span>
                                @else
                                    <div class="flex items-center gap-1.5 text-gray-500">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm font-medium tracking-tight">
                                            {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Jamais connecté' }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <!-- actions PRO -->
                    <td class="px-6 py-4 text-right">
    <div class="flex justify-end gap-1">

        <a href="{{ route('users.show', $user) }}" 
   title="Voir" 
   class="p-2 rounded-lg text-gray-400 hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0"/>
        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
    </svg>
</a>

        <a href="{{ route('users.edit', $user) }}" title="Modifier" class="p-2 rounded-lg text-gray-400 hover:bg-green-50 hover:text-green-600 transition-all duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
        </a>

        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.');" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" title="Supprimer" class="p-2 rounded-lg text-gray-400 hover:bg-red-50 hover:text-red-500 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            </button>
        </form>

    </div>
</td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('js-search-input');
    const roleFilter = document.getElementById('js-role-filter');
    const rows = document.querySelectorAll('.user-row');

    function filterTable() {
        const query = searchInput.value.toLowerCase().trim();
        const selectedRole = roleFilter.value;

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            const role = row.getAttribute('data-role');
            
            const matchesSearch = text.includes(query);
            const matchesRole = (selectedRole === 'all' || role === selectedRole);

            row.style.display = (matchesSearch && matchesRole) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    roleFilter.addEventListener('change', filterTable);
});
</script>

</x-admin-layout>