<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MedCabinet </title>
    <meta name="description" content="Secure, fast, and easy medical appointment management. Access your records, consult top doctors, and book appointments 24/7.">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb', // Professional Medical Blue
                        'primary-dark': '#1d4ed8',
                        'primary-light': '#eff6ff',
                        secondary: '#0f172a',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    },
                    boxShadow: {
                        'glass': '0 8px 32px 0 rgba(31, 38, 135, 0.07)',
                        'soft': '0 20px 40px -15px rgba(0,0,0,0.05)',
                        'card': '0 10px 30px -5px rgba(37, 99, 235, 0.08)',
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Custom Styles for Premium Feel */
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        .text-gradient {
            background: linear-gradient(135deg, #2563eb 0%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .blob-bg {
            position: absolute;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            filter: blur(80px);
            opacity: 0.6;
            z-index: -1;
            border-radius: 50%;
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        .animate-float-delayed {
            animation: float 6s ease-in-out 3s infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        .feature-card:hover .feature-icon {
            background-color: #2563eb;
            color: #ffffff;
            transform: scale(1.1) rotate(5deg);
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-50 overflow-x-hidden">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass-nav transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="#" class="flex items-center gap-2 text-2xl font-heading font-bold text-secondary group">
                        <div class="w-10 h-10 bg-primary text-white flex items-center justify-center rounded-xl shadow-lg shadow-blue-500/30 group-hover:scale-105 transition-transform">
                            <i class="fa-solid fa-notes-medical"></i>
                        </div>
                        MedCabinet
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#services" class="text-gray-600 hover:text-primary font-medium transition-colors">Services</a>
                    <a href="#how-it-works" class="text-gray-600 hover:text-primary font-medium transition-colors">How it works</a>
                    <a href="#about" class="text-gray-600 hover:text-primary font-medium transition-colors">About</a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-2.5 rounded-xl bg-primary text-white font-medium hover:bg-primary-dark transition-all duration-300 shadow-md shadow-blue-500/30 transform hover:-translate-y-0.5">
                                    Sign In / Join
                                </a>
                            @endif
                        @endauth
                    @else
                        <!-- Fallbacks if routes aren't defined -->
                        <a href="/login" class="text-gray-600 hover:text-primary font-medium transition-colors">Log in</a>
                        <a href="/register" class="px-6 py-2.5 rounded-xl bg-primary text-white font-medium hover:bg-primary-dark transition-all duration-300 shadow-md shadow-blue-500/30 transform hover:-translate-y-0.5">
                            Sign In / Join
                        </a>
                    @endif
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button class="text-gray-500 hover:text-primary focus:outline-none">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <!-- Abstract Background Blobs -->
        <div class="blob-bg w-[500px] h-[500px] top-0 left-[-100px]"></div>
        <div class="blob-bg w-[600px] h-[600px] bottom-0 right-[-150px] !bg-blue-100"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <!-- Hero Content -->
                <div class="max-w-xl text-center lg:text-left mx-auto lg:mx-0 xl:pr-10">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 border border-blue-100 text-primary font-medium text-sm mb-6 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                        Smart Healthcare Platform
                    </div>
                    
                    <h1 class="text-5xl lg:text-6xl font-heading font-extrabold leading-[1.1] mb-6 text-secondary">
                        Your Health Journey, <br class="hidden lg:block">
                        <span class="text-gradient">Digitized.</span>
                    </h1>
                    
                    <p class="text-lg lg:text-xl text-gray-600 mb-8 leading-relaxed">
                        Book appointments, access your medical records, and consult with top doctors—all directly from your phone.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('login') ?? '/login' }}" class="inline-flex justify-center items-center px-8 py-4 text-base font-semibold text-white bg-primary rounded-xl shadow-card hover:shadow-lg hover:shadow-blue-500/40 hover:bg-primary-dark transition-all duration-300 transform hover:-translate-y-1 group">
                            Book Now 
                            <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="#how-it-works" class="inline-flex justify-center items-center px-8 py-4 text-base font-semibold text-gray-700 bg-white border border-gray-200 rounded-xl shadow-sm hover:border-primary hover:text-primary transition-all duration-300">
                            Learn More
                        </a>
                    </div>
                    
                    <!-- Social Proof -->
                    <div class="mt-10 flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start">
                        <div class="flex -space-x-3">
                            <img class="w-10 h-10 rounded-full border-2 border-white object-cover shadow-sm" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80" alt="Patient overlay">
                            <img class="w-10 h-10 rounded-full border-2 border-white object-cover shadow-sm" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=100&q=80" alt="Patient overlay">
                            <img class="w-10 h-10 rounded-full border-2 border-white object-cover shadow-sm" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=80" alt="Patient overlay">
                            <div class="w-10 h-10 rounded-full border-2 border-white bg-gray-50 flex items-center justify-center text-xs font-bold text-primary shadow-sm z-10">+5k</div>
                        </div>
                        <div class="text-sm text-gray-600 text-center sm:text-left">
                            <div class="flex items-center justify-center sm:justify-start text-yellow-400 text-xs mb-0.5 space-x-0.5">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            </div>
                            <span class="font-bold text-gray-900">5,000+</span> happy patients managed
                        </div>
                    </div>
                </div>

                <!-- Hero Visual -->
                <div class="relative w-full h-[500px] hidden lg:block">
                    <!-- Main Image Frame -->
                    <div class="absolute inset-y-0 right-0 w-11/12 rounded-[2rem] overflow-hidden shadow-2xl animate-float">
                        <img src="https://images.unsplash.com/photo-1638202993928-7267aad84c31?auto=format&fit=crop&w=800&q=80" alt="Doctor consulting patient smiling" class="w-full h-full object-cover">
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/40 to-transparent mix-blend-multiply"></div>
                    </div>
                    
                    <!-- Floating Stat Card 1 -->
                    <div class="absolute top-16 left-0 bg-white/90 backdrop-blur-md p-4 rounded-2xl shadow-glass flex items-center gap-4 animate-float-delayed border border-white/50 z-20">
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-primary text-xl shadow-inner">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Next Visit</p>
                            <p class="text-gray-900 font-bold font-heading">Today, 14:30</p>
                        </div>
                    </div>

                    <!-- Floating Stat Card 2 -->
                    <div class="absolute bottom-16 -right-6 bg-white/90 backdrop-blur-md p-4 rounded-2xl shadow-glass flex items-center gap-4 animate-float border border-white/50 z-20" style="animation-delay: 1.5s;">
                        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-xl shadow-inner">
                            <i class="fa-solid fa-shield-check"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Data Security</p>
                            <p class="text-gray-900 font-bold font-heading">End-to-End Encryption</p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Trust Bar -->
    <section class="py-10 border-y border-gray-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm font-bold text-gray-400 uppercase tracking-widest mb-8">Trusted by leading healthcare clinics & 5000+ patients</p>
            <div class="flex flex-wrap justify-center items-center gap-12 md:gap-24 opacity-60 grayscale hover:grayscale-0 transition-all duration-500 cursor-default">
                <div class="flex items-center gap-2 font-heading font-bold text-2xl text-gray-800 transition-transform hover:scale-105">
                    <i class="fa-solid fa-house-medical text-primary"></i> MediCore
                </div>
                <div class="flex items-center gap-2 font-heading font-bold text-2xl text-gray-800 transition-transform hover:scale-105">
                    <i class="fa-solid fa-heart-pulse text-red-500"></i> HealthPlus
                </div>
                <div class="flex items-center gap-2 font-heading font-bold text-2xl text-gray-800 transition-transform hover:scale-105">
                    <i class="fa-solid fa-leaf text-green-500"></i> PureLife
                </div>
                <div class="flex items-center gap-2 font-heading font-bold text-2xl text-gray-800 hidden sm:flex transition-transform hover:scale-105">
                    <i class="fa-solid fa-stethoscope text-primary"></i> CareConnect
                </div>
            </div>
        </div>
    </section>

    <!-- Patient Features Grid -->
    <section id="services" class="py-24 bg-gray-50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-primary font-bold tracking-widest uppercase text-xs mb-3">Why Choose Us</h2>
                <h3 class="text-3xl md:text-4xl font-heading font-bold text-secondary mb-4">Everything you need for your health, in one place</h3>
                <p class="text-gray-600 text-lg">We've designed a platform that puts the patient first, ensuring convenience, security, and immediate accessibility.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-[2rem] p-8 shadow-soft border border-gray-100 transition-all duration-300 hover:-translate-y-2 hover:shadow-card group feature-card relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary-light rounded-bl-full -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-110"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-primary-light rounded-2xl flex items-center justify-center text-primary text-2xl mb-6 transition-all duration-300 feature-icon shadow-sm">
                            <i class="fa-regular fa-calendar-check"></i>
                        </div>
                        <h4 class="text-xl font-heading font-bold text-secondary mb-3">Easy Booking</h4>
                        <p class="text-gray-600 leading-relaxed text-sm">24/7 online appointment scheduling. View available slots and book your preferred time instantly without waiting on hold.</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-[2rem] p-8 shadow-soft border border-gray-100 transition-all duration-300 hover:-translate-y-2 hover:shadow-card group feature-card relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary-light rounded-bl-full -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-110"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-primary-light rounded-2xl flex items-center justify-center text-primary text-2xl mb-6 transition-all duration-300 feature-icon shadow-sm">
                            <i class="fa-solid fa-file-medical"></i>
                        </div>
                        <h4 class="text-xl font-heading font-bold text-secondary mb-3">Personal Dashboard</h4>
                        <p class="text-gray-600 leading-relaxed text-sm">Access your comprehensive medical history, digital prescriptions (PDFs), and lab results anytime, directly from your pocket.</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-[2rem] p-8 shadow-soft border border-gray-100 transition-all duration-300 hover:-translate-y-2 hover:shadow-card group feature-card relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary-light rounded-bl-full -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-110"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-primary-light rounded-2xl flex items-center justify-center text-primary text-2xl mb-6 transition-all duration-300 feature-icon shadow-sm">
                            <i class="fa-regular fa-bell"></i>
                        </div>
                        <h4 class="text-xl font-heading font-bold text-secondary mb-3">Smart Alerts</h4>
                        <p class="text-gray-600 leading-relaxed text-sm">Never miss an important appointment. Receive automated, timely Email & SMS reminders leading up to your upcoming visits.</p>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white rounded-[2rem] p-8 shadow-soft border border-gray-100 transition-all duration-300 hover:-translate-y-2 hover:shadow-card group feature-card relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary-light rounded-bl-full -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-110"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-primary-light rounded-2xl flex items-center justify-center text-primary text-2xl mb-6 transition-all duration-300 feature-icon shadow-sm">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h4 class="text-xl font-heading font-bold text-secondary mb-3">Top Security</h4>
                        <p class="text-gray-600 leading-relaxed text-sm">Your privacy is paramount. We utilize end-to-end encryption to protect exclusively all your highly sensitive medical data.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visual Process (Steps) -->
    <section id="how-it-works" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-20">
                <h2 class="text-primary font-bold tracking-widest uppercase text-xs mb-3">Simple Process</h2>
                <h3 class="text-3xl md:text-4xl font-heading font-bold text-secondary mb-4">How It Works</h3>
                <p class="text-gray-600 text-lg">Managing your healthcare workflow should be effortless. We've simplified it to just three easy steps.</p>
            </div>

            <div class="relative">
                <!-- Connecting Background Line for Desktop -->
                <div class="hidden md:block absolute top-[45px] left-[15%] right-[15%] h-[3px] bg-gray-100 -z-0"></div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative z-10">
                    <!-- Step 1 -->
                    <div class="text-center group px-6">
                        <div class="w-24 h-24 mx-auto bg-white border-[6px] border-gray-50 rounded-full flex items-center justify-center text-3xl font-heading font-bold text-gray-300 mb-6 transition-all duration-500 group-hover:border-primary-light group-hover:text-primary group-hover:scale-110 shadow-lg relative">
                            1
                            <div class="absolute -right-1 -bottom-1 w-10 h-10 rounded-full bg-primary flex items-center justify-center text-sm text-white shadow-md transform rotate-[-10deg] group-hover:rotate-0 transition-transform">
                                <i class="fa-solid fa-user-doctor"></i>
                            </div>
                        </div>
                        <h4 class="text-xl font-heading font-bold text-secondary mb-3">Find a Specialist</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Browse our verified directory of healthcare professionals across multiple medical specialties.</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center group px-6 mt-8 md:mt-0">
                        <div class="w-24 h-24 mx-auto bg-white border-[6px] border-gray-50 rounded-full flex items-center justify-center text-3xl font-heading font-bold text-gray-300 mb-6 transition-all duration-500 group-hover:border-primary-light group-hover:text-primary group-hover:scale-110 shadow-lg relative">
                            2
                            <div class="absolute -right-1 -bottom-1 w-10 h-10 rounded-full bg-primary flex items-center justify-center text-sm text-white shadow-md transform rotate-[-10deg] group-hover:rotate-0 transition-transform">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                        </div>
                        <h4 class="text-xl font-heading font-bold text-secondary mb-3">Choose a Slot</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Select a date and time that fits seamlessly into your busy personal schedule.</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center group px-6 mt-8 md:mt-0">
                        <div class="w-24 h-24 mx-auto bg-white border-[6px] border-gray-50 rounded-full flex items-center justify-center text-3xl font-heading font-bold text-gray-300 mb-6 transition-all duration-500 group-hover:border-primary-light group-hover:text-primary group-hover:scale-110 shadow-lg relative">
                            3
                            <div class="absolute -right-1 -bottom-1 w-10 h-10 rounded-full bg-primary flex items-center justify-center text-sm text-white shadow-md transform rotate-[-10deg] group-hover:rotate-0 transition-transform">
                                <i class="fa-solid fa-check"></i>
                            </div>
                        </div>
                        <h4 class="text-xl font-heading font-bold text-secondary mb-3">Get Notified</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Receive your instant appointment confirmation and timely reminders leading up to your visit.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="py-24 bg-primary relative overflow-hidden">
        <!-- Abstract patterns for visual interest -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full blur-[100px] transform translate-x-1/3 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-black opacity-10 rounded-full blur-[100px] transform -translate-x-1/3 translate-y-1/2"></div>
        
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <i class="fa-solid fa-quote-left text-5xl text-blue-300/40 mb-8 transform -scale-x-100 inline-block"></i>
            
            <h3 class="text-2xl md:text-3xl lg:text-4xl font-heading font-medium text-white mb-12 leading-[1.4] max-w-3xl mx-auto">
                "The absolute easiest way to manage my family's health appointments. I love perfectly having all my digital prescriptions securely in one place, accessible straight from my phone."
            </h3>
            
            <div class="flex items-center justify-center gap-5">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=150&q=80" alt="Patient Sarah" class="w-16 h-16 rounded-full border-2 border-blue-300 object-cover shadow-lg">
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full border-2 border-primary flex items-center justify-center text-white text-[10px]">
                        <i class="fa-solid fa-check"></i>
                    </div>
                </div>
                <div class="text-left">
                    <div class="font-bold text-white text-lg font-heading">Sarah Jenkins</div>
                    <div class="flex text-yellow-400 text-xs gap-0.5 mb-1">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <div class="text-blue-200 text-sm font-medium">Verified Patient</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="about" class="bg-secondary pt-20 pb-10 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                
                <!-- Brand Col -->
                <div class="col-span-1 lg:col-span-1 border-b md:border-b-0 border-gray-800 pb-8 md:pb-0">
                    <a href="#" class="flex items-center gap-2 text-2xl font-heading font-bold text-white mb-6">
                        <div class="w-10 h-10 bg-primary text-white flex items-center justify-center rounded-xl shadow-lg shadow-blue-500/20">
                            <i class="fa-solid fa-notes-medical"></i>
                        </div>
                        MedCabinet
                    </a>
                    <p class="text-gray-400 text-sm mb-8 leading-relaxed">
                        Modernizing healthcare management to bring doctors and patients closer together in an intuitive, unified, and secure environment.
                    </p>
                    <div class="flex space-x-5">
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition-all shadow-sm"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition-all shadow-sm"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-primary hover:text-white transition-all shadow-sm"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>

                <!-- Links 1 -->
                <div>
                    <h4 class="text-white font-bold mb-6 tracking-wide font-heading">Quick Links</h4>
                    <ul class="space-y-4 text-sm font-medium">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs text-primary"></i> Find a Doctor</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs text-primary"></i> Our Services</a></li>
                        <li><a href="#how-it-works" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs text-primary"></i> How it Works</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs text-primary"></i> About Us</a></li>
                    </ul>
                </div>

                <!-- Links 2 -->
                <div>
                    <h4 class="text-white font-bold mb-6 tracking-wide font-heading">Legal Info</h4>
                    <ul class="space-y-4 text-sm font-medium">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs text-primary"></i> Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs text-primary"></i> Terms of Service</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs text-primary"></i> Cookie Policy</a></li>
                    </ul>
                </div>

                <!-- Security Box -->
                <div>
                    <h4 class="text-white font-bold mb-6 tracking-wide font-heading">Trust & Security</h4>
                    <div class="bg-gray-800/50 p-5 rounded-2xl border border-gray-700/50 flex items-start gap-4">
                        <div class="text-green-500 text-3xl"><i class="fa-solid fa-shield-check"></i></div>
                        <div>
                            <div class="text-white font-bold text-sm mb-1">Secure System</div>
                            <div class="text-xs text-gray-400 leading-relaxed">100% HIPAA-compliant infrastructure. Your medical data is protected with end-to-end multi-layer encryption.</div>
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="pt-8 border-t border-gray-800/80 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-sm text-gray-500">&copy; <span id="year">2026</span> Medical Cabinet Management System. All rights reserved.</p>
                <div class="flex items-center gap-2 text-gray-500 text-sm">
                    Made with <i class="fa-solid fa-heart text-red-500/70"></i> for patients.
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Update copyright year natively if blade tag fails
        document.getElementById('year').innerText = new Date().getFullYear();
        
        // Setup navbar blur on scroll for deeper effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 20) {
                navbar.classList.add('shadow-sm');
                navbar.classList.replace('glass-nav', 'bg-white/95');
                navbar.classList.add('backdrop-blur-xl');
            } else {
                navbar.classList.remove('shadow-sm');
                navbar.classList.replace('bg-white/95', 'glass-nav');
                navbar.classList.remove('backdrop-blur-xl');
            }
        });
    </script>
</body>
</html>
