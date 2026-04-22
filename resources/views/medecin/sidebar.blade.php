<aside class="w-64 bg-white shadow-lg min-h-screen flex flex-col fixed top-0 left-0">
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-col items-center text-center">
            <div class="w-16 h-16 rounded-full bg-green-600 flex items-center justify-center text-white text-xl font-bold mb-3">
                {{ strtoupper(substr(auth()->user()->nom, 0, 1)) }}{{ strtoupper(substr(auth()->user()->prenom, 0, 1)) }}
            </div>
            <p class="font-semibold text-gray-800 text-sm">Dr. {{ auth()->user()->nom }} {{ auth()->user()->prenom }}</p>
            <span class="mt-1 text-xs text-green-600 font-medium bg-green-50 px-3 py-1 rounded-full">Médecin</span>
        </div>
    </div>

    <nav class="flex-1 p-4 space-y-1">

        <a href="{{ route('medecin.dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('medecin.dashboard') ? 'bg-green-50 text-green-600' : 'text-gray-600 hover:bg-gray-50 hover:text-green-600' }} font-medium text-sm transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
            Dashboard
        </a>

        <a href="{{ route('medecin.rendezvous') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('medecin.rendezvous') ? 'bg-green-50 text-green-600' : 'text-gray-600 hover:bg-gray-50 hover:text-green-600' }} font-medium text-sm transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Mes Rendez-vous
        </a>

        <a href="{{ route('medecin.patients') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('medecin.patients') ? 'bg-green-50 text-green-600' : 'text-gray-600 hover:bg-gray-50 hover:text-green-600' }} font-medium text-sm transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Mes Patients
        </a>

        <a href="{{ route('medecin.consultations') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('medecin.consultations') ? 'bg-green-50 text-green-600' : 'text-gray-600 hover:bg-gray-50 hover:text-green-600' }} font-medium text-sm transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Mes Consultations
        </a>

        <a href="{{ route('medecin.profil') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('medecin.profil') ? 'bg-green-50 text-green-600' : 'text-gray-600 hover:bg-gray-50 hover:text-green-600' }} font-medium text-sm transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Mon Profil
        </a>

    </nav>

    <div class="p-4 border-t border-gray-100">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center gap-3 px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 font-medium text-sm transition w-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Déconnexion
            </button>
        </form>
    </div>
</aside>
