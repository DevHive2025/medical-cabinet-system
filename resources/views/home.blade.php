<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabinet Médical</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-2xl">🏥</span>
                <span class="text-xl font-bold text-gray-800">Cabinet Médical</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('patients.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                    Accéder au cabinet
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="bg-gradient-to-br from-green-600 to-green-800 text-white py-20">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h1 class="text-4xl font-bold mb-4">Bienvenue au Cabinet Médical</h1>
            <p class="text-green-100 text-lg mb-8">Votre santé, notre priorité. Prenez rendez-vous en ligne facilement.</p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('patients.index') }}" class="bg-white text-green-700 hover:bg-green-50 px-6 py-3 rounded-xl font-semibold transition">
                    Voir les patients
                </a>
                <a href="{{ route('dossierMedical.index') }}" class="border border-white text-white hover:bg-green-700 px-6 py-3 rounded-xl font-semibold transition">
                    Dossiers médicaux
                </a>
            </div>
        </div>
    </section>

    <!-- Infos Cabinet -->
    <section class="max-w-6xl mx-auto px-6 py-16">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-10">Informations du Cabinet</h2>

        <div class="grid grid-cols-3 gap-6">

            <!-- Horaires -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-green-100 text-green-600 rounded-lg p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800">Horaires d'ouverture</h3>
                </div>
                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Lundi — Vendredi</span>
                        <span class="font-medium text-gray-800">8h00 — 18h00</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Samedi</span>
                        <span class="font-medium text-gray-800">9h00 — 13h00</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Dimanche</span>
                        <span class="font-medium text-red-500">Fermé</span>
                    </div>
                </div>
            </div>

            <!-- Contact -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-blue-100 text-blue-600 rounded-lg p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800">Contact</h3>
                </div>
                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <span>📞</span>
                        <span>+212 5XX-XXXXXX</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>📧</span>
                        <span>contact@cabinet.ma</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>📍</span>
                        <span>123 Rue de la Santé, Casablanca</span>
                    </div>
                </div>
            </div>

            <!-- Urgences -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-red-100 text-red-600 rounded-lg p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-800">Urgences</h3>
                </div>
                <div class="space-y-2 text-sm text-gray-600">
                    <p>En cas d'urgence médicale :</p>
                    <p class="text-2xl font-bold text-red-600">15</p>
                    <p class="text-xs text-gray-500">SAMU — disponible 24h/24</p>
                </div>
            </div>

        </div>
    </section>

    <!-- Services -->
    <section class="bg-white py-16">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-2xl font-bold text-gray-800 text-center mb-10">Nos Services</h2>
            <div class="grid grid-cols-4 gap-6">
                <div class="text-center p-6">
                    <div class="text-4xl mb-3">🩺</div>
                    <h3 class="font-semibold text-gray-800 mb-2">Consultation Générale</h3>
                    <p class="text-sm text-gray-500">Suivi médical complet et personnalisé</p>
                </div>
                <div class="text-center p-6">
                    <div class="text-4xl mb-3">❤️</div>
                    <h3 class="font-semibold text-gray-800 mb-2">Cardiologie</h3>
                    <p class="text-sm text-gray-500">Diagnostic et traitement des maladies cardiaques</p>
                </div>
                <div class="text-center p-6">
                    <div class="text-4xl mb-3">🦷</div>
                    <h3 class="font-semibold text-gray-800 mb-2">Dentisterie</h3>
                    <p class="text-sm text-gray-500">Soins dentaires et hygiène bucco-dentaire</p>
                </div>
                <div class="text-center p-6">
                    <div class="text-4xl mb-3">👁️</div>
                    <h3 class="font-semibold text-gray-800 mb-2">Ophtalmologie</h3>
                    <p class="text-sm text-gray-500">Examen de la vue et traitement oculaire</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-400 py-8">
        <div class="max-w-6xl mx-auto px-6 text-center text-sm">
            <p>© {{ date('Y') }} Cabinet Médical — Tous droits réservés</p>
        </div>
    </footer>

</body>
</html>
