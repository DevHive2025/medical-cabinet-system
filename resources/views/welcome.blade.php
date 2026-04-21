<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MediCare - Home</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .hero-gradient {
            background: radial-gradient(circle at 20% 30%, #134e4a 0%, #0d9488 40%, #0f766e 70%, #115e59 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        .animate-float {
            animation: float 6s infinite ease-in-out;
        }
    </style>
</head>

<body class="bg-[#0d9488] antialiased overflow-hidden">

<!-- HEADER -->
<header class="absolute w-full z-50">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-6">

        <div class="flex items-center gap-2">
            <div class="bg-white p-2 rounded-xl shadow-lg">
                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                </svg>
            </div>
            <span class="text-2xl font-extrabold text-white">MediCare</span>
        </div>

        <nav class="hidden md:flex gap-8">
            <a href="#" class="text-white/90 hover:text-white">Home</a>
            <a href="#" class="text-white/80 hover:text-white">Services</a>
            <a href="#" class="text-white/80 hover:text-white">Doctors</a>
            <a href="#" class="text-white/80 hover:text-white">Contact</a>
        </nav>

        <div class="flex items-center gap-4">
            <a href="{{ route('login') }}" class="text-white font-semibold">Login</a>
            <a href="{{ route('register') }}" class="px-5 py-2 bg-white text-teal-700 rounded-full font-bold shadow-lg">
                Register
            </a>
        </div>

    </div>
</header>

<!-- HERO -->
<section class="hero-gradient h-screen flex items-center relative overflow-hidden">

    <!-- background glow -->
    <div class="absolute top-[-10%] right-[-5%] w-[400px] h-[400px] bg-teal-400/20 rounded-full blur-[120px]"></div>

    <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center relative z-10 pt-24">

        <!-- LEFT -->
        <div class="space-y-6">

            <div class="glass-effect px-4 py-2 rounded-full text-teal-50 text-sm inline-flex items-center gap-2">
                <span class="w-2 h-2 bg-teal-400 rounded-full animate-pulse"></span>
                Trusted by 4,000+ Patients
            </div>

            <h1 class="text-5xl lg:text-6xl font-extrabold text-white leading-tight">
                Take care of <br>
                <span class="bg-gradient-to-r from-teal-200 to-white bg-clip-text text-transparent">
                    your health
                </span> online
            </h1>

            <p class="text-teal-100 text-base max-w-md">
                Manage appointments, access records, and connect with doctors easily.
            </p>

            <a href="{{ route('register') }}"
               class="inline-block px-8 py-3 bg-[#2dd4bf] text-[#042f2e] rounded-xl font-bold shadow-xl hover:bg-white transition">
                Book Appointment
            </a>

        </div>

        <!-- RIGHT -->
        <div class="relative flex justify-center">

            <!-- glow -->

            <div class="relative z-10 w-full max-w-[420px]">

                <!-- image -->
                <img src="https://pngimg.com/uploads/doctor/doctor_PNG16041.png"
                alt="Doctor"
                class="w-full object-contain drop-shadow-[0_50px_80px_rgba(0,0,0,0.45)]
                        ">

                <!-- blend gradient -->
                <div class="absolute inset-0 
                            bg-gradient-to-t from-[#0d9488]/50 to-transparent
                            pointer-events-none"></div>

                <!-- floating card -->
                <div class="absolute bottom-10 left-0 
                            bg-white px-4 py-3 rounded-xl shadow-2xl 
                            flex items-center gap-3 animate-float">

                    <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2.5" d="M9 12l2 2 4-4"></path>
                        </svg>
                    </div>

                    <div>
                        <p class="text-xs text-teal-600 font-bold">Professional</p>
                        <p class="text-sm font-bold text-gray-900">Certified Doctors</p>
                    </div>

                </div>

            </div>

        </div>

    </div>
</section>

</body>
</html>