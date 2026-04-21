<x-admin-layout>
    <div class="p-6 space-y-6">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Tableau de Bord</h1>
                <p class="text-gray-600">Bienvenue sur votre espace de gestion médicale</p>
            </div>
            <div class="text-sm font-medium text-gray-500 bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-100">
                Aujourd'hui: {{ now()->format('d/m/Y') }}
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-sm font-medium text-gray-500 uppercase">RDV Aujourd'hui</h3>
                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $rdvAujourdhui }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-sm font-medium text-gray-500 uppercase">Patients </h3>
                <div class="flex items-baseline gap-2 mt-2">
                    <p class="text-3xl font-bold text-gray-900">{{ $lastMonthCount }}</p>
                    <span class="text-sm font-semibold {{ $percentageIncrease >= 0 ? 'text-green-500' : 'text-red-500' }}">
                        {{ $percentageIncrease >= 0 ? '+' : '' }}{{ round($percentageIncrease, 1) }}%
                    </span>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-sm font-medium text-gray-500 uppercase">Médecins en Service</h3>
                <p class="text-3xl font-bold text-green-600 mt-2">{{ $medecinsTravail }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-xl font-bold text-gray-800 mb-6">System Status</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 font-medium">Server Status</span>
                        <span class="px-2 py-0.5 bg-green-100 text-green-600 text-xs font-bold rounded shadow-sm">Online</span>
                    </div>
                    <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-blue-500 h-full rounded-full" style="width: 98%"></div>
                    </div>
                    <p class="text-sm text-gray-400">98% Uptime</p>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 font-medium">Database</span>
                        <span class="px-2 py-0.5 bg-green-100 text-green-600 text-xs font-bold rounded shadow-sm">Healthy</span>
                    </div>
                    <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-green-500 h-full rounded-full" style="width: 92%"></div>
                    </div>
                    <p class="text-sm text-gray-400">92% Capacity</p>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 font-medium">API Response</span>
                        <span class="px-2 py-0.5 bg-green-100 text-green-600 text-xs font-bold rounded shadow-sm">Fast</span>
                    </div>
                    <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                        <div class="bg-orange-500 h-full rounded-full" style="width: 85%"></div>
                    </div>
                    <p class="text-sm text-gray-400">45ms Average</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ openModal: false, logDetails: {} }">
            <div class="p-4 border-b border-gray-50 bg-gray-50">
                <h3 class="font-bold text-gray-800">Journal d'activités récentes</h3>
            </div>
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                    <tr>
                        <th class="p-4">Utilisateur</th>
                        <th class="p-4">Action</th>
                        <th class="p-4">Date</th>
                        <th class="p-4">Détails</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    @foreach($recentLogs as $log)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-700">{{ $log->user->prenom }} {{ $log->user->nom }}</span>
                                @if($log->user->medecin)
                                    <span class="text-[10px] font-bold text-purple-600 uppercase tracking-wider">Médecin</span>
                                @elseif($log->user->patient)
                                    <span class="text-[10px] font-bold text-green-600 uppercase tracking-wider">Patient</span>
                                @elseif($log->user->secretaire)
                                    <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Secrétaire</span>
                                @elseif($log->user->isAdmin())
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Administrateur</span>
                                @endif
                            </div>
                        </td>

                        <td class="p-4">
                            <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-md text-xs font-medium">{{ $log->action }}</span>
                        </td>
                        
                        <td class="p-4 text-gray-500 text-xs">{{ $log->created_at->diffForHumans() }}</td>

                        <td class="p-4 text-left">
                            <button 
                                @click="openModal = true; logDetails = { 
                                    user: '{{ $log->user->prenom }} {{ $log->user->nom }}',
                                    action: '{{ $log->action }}',
                                    description: `{{ $log->description }}`,
                                    ip: '{{ $log->ip_address }}',
                                    agent: '{{ $log->user_agent }}',
                                    date: '{{ $log->created_at->format('d/m/Y H:i') }}'
                                }" 
                                class="text-gray-400 hover:text-blue-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div 
    x-show="openModal" 
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto bg-gray-900/50 backdrop-blur-sm"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    x-cloak
>
    <div 
        @click.away="openModal = false"
        class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
    >
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Détails de l'activité
            </h3>
            <button @click="openModal = false" class="text-gray-400 hover:text-gray-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="p-6 space-y-4">
            <div class="grid grid-cols-1 gap-4">
                <div class="bg-blue-50/30 p-3 rounded-lg border border-blue-100">
                    <p class="text-xs text-blue-500 uppercase font-bold tracking-wider mb-1">Action</p>
                    <p class="text-blue-900 font-semibold" x-text="logDetails.action"></p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Utilisateur</p>
                        <p class="text-gray-700 font-medium" x-text="logDetails.user"></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Date</p>
                        <p class="text-gray-700 font-medium" x-text="logDetails.date"></p>
                    </div>
                </div>

                <hr class="border-gray-100">

                <div>
                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Description</p>
                    <p class="text-gray-600 italic bg-gray-50 p-2 rounded border border-gray-100" x-text="logDetails.description || 'Aucune description'"></p>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                        <span class="text-gray-500 font-mono" x-text="logDetails.ip"></span>
                    </div>
                    <span class="text-[10px] text-gray-400 font-mono truncate max-w-[200px]" x-text="logDetails.agent"></span>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 flex justify-end">
            <button 
                @click="openModal = false" 
                class="px-5 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-100 transition-all shadow-sm"
            >
                Fermer
            </button>
        </div>
    </div>
</div>
        </div>
    </div>
</x-admin-layout>
