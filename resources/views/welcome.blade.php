<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MediCare</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-900">

<!-- NAVBAR -->
<header class="border-b bg-white">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">

        <!-- LOGO (Lucide Activity Icon) -->
        <div class="flex items-center gap-2 font-bold text-xl text-blue-600">

            <svg xmlns="http://www.w3.org/2000/svg"
                 width="24" height="24" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round"
                 class="w-7 h-7 text-blue-600">
                <path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2"></path>
            </svg>

            MediCare
        </div>

        <!-- NAV -->
        <nav class="hidden md:flex gap-8 text-gray-600">
            <a href="#" class="hover:text-blue-600">Home</a>
            <a href="#" class="hover:text-blue-600">Services</a>
            <a href="#" class="hover:text-blue-600">About</a>
            <a href="#" class="hover:text-blue-600">Contact</a>
        </nav>

        <!-- AUTH -->
        <div class="flex items-center gap-4">
            <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600">
                Login
            </a>

            <a href="{{ route('register') }}"
               class="px-5 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700">
                Register
            </a>
        </div>

    </div>
</header>

<!-- HERO -->
<section class="max-w-7xl mx-auto px-6 py-20 grid md:grid-cols-2 gap-10 items-center">

    <!-- LEFT SIDE -->
    <div>
        <h1 class="text-5xl font-bold leading-tight">
            Manage your medical <br>
            <span class="text-blue-600">appointments easily</span>
        </h1>

        <p class="mt-6 text-gray-600 text-lg">
            A modern platform to book appointments, manage medical records, and connect with healthcare professionals seamlessly.
        </p>

        <div class="mt-8 flex gap-4">
            <a href="{{ route('register') }}"
               class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700">
                Book Appointment
            </a>

            <a href="{{ route('login') }}"
               class="px-6 py-3 border rounded-xl hover:bg-gray-50">
                Login
            </a>
        </div>
    </div>

    <!-- RIGHT SIDE CARDS -->
    <div class="space-y-4">

        <!-- CARD 1 -->
        <div class="flex items-center gap-4 p-5 rounded-2xl bg-blue-50">
            <div class="p-3 bg-blue-600 text-white rounded-xl">
                <!-- Calendar -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M8.25 6V4.5m7.5 1.5V4.5M3.75 9h16.5M4.5 6.75h15A2.25 2.25 0 0118 9v9.75A2.25 2.25 0 0115.75 21h-7.5A2.25 2.25 0 016 18.75V9a2.25 2.25 0 012.25-2.25z" />
                </svg>
            </div>
            <div>
                <h3 class="font-semibold">Easy Scheduling</h3>
                <p class="text-sm text-gray-600">Book appointments 24/7</p>
            </div>
        </div>

        <!-- CARD 2 -->
        <div class="flex items-center gap-4 p-5 rounded-2xl bg-green-50">
            <div class="p-3 bg-green-600 text-white rounded-xl">
                <!-- Document -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125V5.25m0 0V3.375m0 1.875h-3A2.625 2.625 0 007.875 7.875v9.75A2.625 2.625 0 0010.5 20.25h3A2.625 2.625 0 0016.125 17.625V14.25" />
                </svg>
            </div>
            <div>
                <h3 class="font-semibold">Digital Records</h3>
                <p class="text-sm text-gray-600">Access anytime, anywhere</p>
            </div>
        </div>

        <!-- CARD 3 -->
        <div class="flex items-center gap-4 p-5 rounded-2xl bg-purple-50">
            <div class="p-3 bg-purple-600 text-white rounded-xl">
                <!-- Heart -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733C11.285 4.876 9.623 3.75 7.688 3.75 5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                </svg>
            </div>
            <div>
                <h3 class="font-semibold">Health Tracking</h3>
                <p class="text-sm text-gray-600">Monitor your progress</p>
            </div>
        </div>

    </div>

</section>

</body>
</html>