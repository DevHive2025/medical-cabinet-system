<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MediCare') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 selection:bg-blue-100 selection:text-blue-900 bg-[#f4f7f6]">

<div class="min-h-screen flex" x-data="{ sidebarOpen: false, userMenuOpen: false }">

    <!-- OVERLAY FOR MOBILE -->
    <div x-show="sidebarOpen" x-transition.opacity style="display: none;" class="fixed inset-0 z-40 bg-gray-900/40 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false"></div>

    <!-- SIDEBAR -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-[17.5rem] bg-white border-r border-gray-100 flex flex-col transition-transform duration-300 lg:translate-x-0 lg:static lg:w-[17.5rem] shadow-[10px_0_40px_rgba(0,0,0,0.03)] lg:shadow-none">

        <!-- LOGO -->
        <div class="pt-8 pb-8 px-8 flex items-center font-semibold text-gray-900 text-[1.4rem] tracking-tight shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 mr-3 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2" />
            </svg>
            MediCare
        </div>

        <!-- USER SECTION -->
        <div class="px-6 mb-7 shrink-0">
            <div class="bg-[#f0f5ff] rounded-[1rem] p-4 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-[#1b5df9] flex items-center justify-center text-white font-semibold shrink-0 text-lg tracking-wide">
                    {{ substr(Auth::user()->nom, 0, 1) }}{{ substr(Auth::user()->prenom, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[0.95rem] text-[#1c2b42] truncate">{{ Auth::user()->nom }} {{ Auth::user()->prenom }}</p>
                    <p class="text-[0.8rem] text-blue-500 font-medium capitalize">{{ Auth::user()->role }}</p>
                </div>
            </div>
        </div>

        <!-- MENU -->
        <nav class="flex-1 px-6 space-y-1.5 overflow-y-auto pb-4">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-[#f0f5ff] text-blue-600' : 'text-[#50637b] hover:bg-gray-50' }}">
                <svg class="w-5 h-5 shrink-0 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-[#8898aa]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="text-[0.95rem]">Dashboard</span>
            </a>
            
            <a href="{{ route('patients.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 text-[#50637b] hover:bg-gray-50">
                <svg class="w-5 h-5 shrink-0 text-[#8898aa]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="text-[0.95rem]">patient</span>
            </a>
            
            <a href="{{ route('dossierMedical.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 text-[#50637b] hover:bg-gray-50">
                <svg class="w-5 h-5 shrink-0 text-[#8898aa]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                <span class="text-[0.95rem]">Dossiers Médicaux</span>
            </a>

            <a href="{{ route('rendez-vous.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 text-[#50637b] hover:bg-gray-50">
                <svg class="w-5 h-5 shrink-0 text-[#8898aa]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="text-[0.95rem]">Rendez-vous</span>
            </a>

            <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 text-[#50637b] hover:bg-gray-50">
                <svg class="w-5 h-5 shrink-0 text-[#8898aa]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="text-[0.95rem]">Accueil</span>
            </a>

            <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 text-[#50637b] hover:bg-gray-50">
                <svg class="w-5 h-5 shrink-0 text-[#8898aa]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span class="text-[0.95rem]">Profile</span>
            </a>
        </nav>

        <!-- SIDEBAR BOTTOM -->
        <div class="px-6 py-8 shrink-0 mt-auto">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="flex items-center gap-4 px-4 py-2 text-[0.95rem] text-[#2c3e50] hover:text-blue-600 transition-colors w-full">
                    <svg class="w-5 h-5 text-[#8898aa]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">

        <!-- TOP NAVBAR -->
        <header class="h-[5rem] bg-white border-b border-gray-100 flex items-center justify-between px-6 shrink-0 z-30">
            <!-- LEFT (MOBILE MENU & TITLE) -->
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 -ml-2 rounded-lg text-gray-500 hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                @isset($header)
                    <div class="text-[1.35rem] font-bold tracking-tight text-gray-900">
                        {{ $header }}
                    </div>
                @endisset
            </div>

            <!-- RIGHT NAVBAR -->
            <div class="flex items-center gap-4 relative">
                
                <!-- Notification Bell -->
                <button class="p-2.5 text-gray-400 hover:text-blue-600 transition-colors rounded-full hover:bg-blue-50 relative">
                    <svg class="w-[1.4rem] h-[1.4rem]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute top-[0.6rem] right-[0.6rem] w-[0.45rem] h-[0.45rem] bg-blue-600 rounded-full border-2 border-white"></span>
                </button>


            </div>
            
        </header>

        <!-- PAGE CONTENT CONTAINER -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8">
            <div class="max-w-[85rem] mx-auto w-full">
                <!-- Wrapper for glassmorphism / card feel -->
                <div class="bg-white/60 backdrop-blur-xl border border-white rounded-[1.5rem] p-6 lg:p-10 shadow-sm w-full min-h-[calc(100vh-10rem)]">
                    {{ $slot }}
                </div>
            </div>
        </main>

    </div>

</div>

</body>
</html>
