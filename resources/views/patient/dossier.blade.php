<x-app-layout>
<div class="max-w-7xl mx-auto py-8">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Mon Dossier Médical</h1>
            <p class="text-sm text-gray-500 mt-1">Informations médicales en lecture seule</p>
        </div>

        @if($patient->dossierMedical)

        <!-- Infos Patient -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-blue-600 flex items-center justify-center text-white text-xl font-bold">
                    {{ strtoupper(substr(auth()->user()->nom, 0, 1)) }}{{ strtoupper(substr(auth()->user()->prenom, 0, 1)) }}
                </div>
                <div>
                    <p class="text-lg font-semibold text-gray-800">{{ auth()->user()->nom }} {{ auth()->user()->prenom }}</p>
                    <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                </div>
                <div class="ml-auto grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Date de naissance</span>
                        <p class="font-medium text-gray-800">{{ $patient->date_naissance }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">Téléphone</span>
                        <p class="font-medium text-gray-800">{{ $patient->telephone }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">N° Sécurité Sociale</span>
                        <p class="font-medium text-gray-800">{{ $patient->num_securite_sociale }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">Adresse</span>
                        <p class="font-medium text-gray-800">{{ $patient->adresse ?? '—' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Données médicales -->
        <div class="grid grid-cols-2 gap-6">

            <!-- Historique -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-blue-100 text-blue-600 rounded-lg p-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h2 class="text-base font-semibold text-gray-800">Historique Médical</h2>
                </div>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $patient->dossierMedical->historique ?? 'Aucun historique renseigné.' }}</p>
            </div>

            <!-- Antécédents -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-yellow-100 text-yellow-600 rounded-lg p-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h2 class="text-base font-semibold text-gray-800">Antécédents</h2>
                </div>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $patient->dossierMedical->antecedents ?? 'Aucun antécédent renseigné.' }}</p>
            </div>

            <!-- Allergies -->
            <div class="bg-white rounded-xl shadow p-6 col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-red-100 text-red-600 rounded-lg p-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                    </div>
                    <h2 class="text-base font-semibold text-gray-800">Allergies</h2>
                </div>
                @if($patient->dossierMedical->allergies)
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $patient->dossierMedical->allergies) as $allergie)
                            <span class="bg-red-100 text-red-600 text-sm font-medium px-4 py-2 rounded-full">
                                {{ trim($allergie) }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-400">Aucune allergie renseignée.</p>
                @endif
            </div>

        </div>

        @else
            <div class="bg-white rounded-xl shadow p-12 text-center">
                <div class="text-5xl mb-4">📋</div>
                <p class="text-gray-500 font-medium">Aucun dossier médical trouvé.</p>
                <p class="text-gray-400 text-sm mt-1">Contactez votre médecin pour créer votre dossier.</p>
            </div>
        @endif


</div >
</x-app-layout>

