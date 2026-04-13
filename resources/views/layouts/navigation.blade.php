<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}" class="text-lg font-bold text-green-700">🏥 Cabinet Médical</a>
                <a href="{{ route('patients.index') }}" class="text-sm text-gray-600 hover:text-green-600 font-medium transition">Patients</a>
                <a href="{{ route('dossierMedical.index') }}" class="text-sm text-gray-600 hover:text-green-600 font-medium transition">Dossiers Médicaux</a>
            </div>
        </div>
    </div>
</nav>
