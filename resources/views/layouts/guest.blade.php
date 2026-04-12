<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MediCare') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

<!-- BACKGROUND -->
<div class="min-h-screen flex items-center justify-center relative">

    <!-- LIGHT BLUE GRADIENT -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-blue-100"></div>

    <!-- SOFT GLOW EFFECT -->
    <div class="absolute inset-0 opacity-40"
         style="background: radial-gradient(circle at top, rgba(59,130,246,0.25), transparent 60%);">
    </div>

    <!-- CONTENT -->
    <div class="relative z-10 w-full flex flex-col items-center px-4">

        <!-- LOGO -->
        <a href="/" class="flex items-center gap-2 mb-6 text-blue-600 text-3xl font-bold">

            <svg xmlns="http://www.w3.org/2000/svg"
                 width="24" height="24"
                 viewBox="0 0 24 24"
                 fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round"
                 class="w-8 h-8 text-blue-600">
                <path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2"></path>
            </svg>

            MediCare
        </a>

        <!-- CARD -->
        <div class="w-full max-w-xl p-10 bg-white/70 backdrop-blur-xl border border-white/40 shadow-xl rounded-2xl">
            <!-- TITLE -->
            <h2 class="text-center text-gray-700 text-xl font-semibold mb-6">
                Welcome to MediCare
            </h2>

            <!-- SLOT -->
            <div>
                {{ $slot }}
            </div>

        </div>

    </div>
</div>

</body>
</html>