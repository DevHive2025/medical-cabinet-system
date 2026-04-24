<x-app-layout>
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Calendrier des Rendez-vous</h2>
        <a href="{{ route('rendez-vous.index') }}" class="text-green-600 hover:underline">
            &larr; Retour à la liste classique
        </a>
    </div>
<<<
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="bg-white rounded-2xl shadow p-6 h-max">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-800">
                    {{ ucfirst($selectedDate->translatedFormat('F Y')) }}
                </h3>
                <div class="flex space-x-2">
                    <a href="{{ route('rendez-vous.calendrier', ['date' => $selectedDate->copy()->subMonth()->format('Y-m-d')]) }}" class="p-2 hover:bg-gray-100 rounded-full text-gray-600">&lt;</a>
                    <a href="{{ route('rendez-vous.calendrier', ['date' => $selectedDate->copy()->addMonth()->format('Y-m-d')]) }}" class="p-2 hover:bg-gray-100 rounded-full text-gray-600">&gt;</a>
                </div>
            </div>

            <div class="grid grid-cols-7 gap-1 text-center text-xs font-medium text-gray-500 mb-2">
                <div>Lun</div><div>Mar</div><div>Mer</div><div>Jeu</div><div>Ven</div><div>Sam</div><div>Dim</div>
            </div>

            @php
                $startOfMonth = $selectedDate->copy()->startOfMonth();
                $daysInMonth = $startOfMonth->daysInMonth;
                $startOffset = $startOfMonth->dayOfWeekIso - 1; // 0 pour Lundi, 6 pour Dimanche
            @endphp

            <div class="grid grid-cols-7 gap-y-2 text-center text-sm">
                @for($i = 0; $i < $startOffset; $i++)
                    <div></div>
                @endfor

                @for($day = 1; $day <= $daysInMonth; $day++)
                    @php
                        $currentDayDate = $selectedDate->copy()->day($day)->format('Y-m-d');
                        $isSelected = $selectedDate->format('Y-m-d') === $currentDayDate;
                        $hasRdv = in_array($currentDayDate, $rdvsMois);
                    @endphp

                    <a href="{{ route('rendez-vous.calendrier', ['date' => $currentDayDate]) }}" 
                       class="relative flex flex-col items-center justify-center w-8 h-8 mx-auto rounded-full cursor-pointer transition 
                       {{ $isSelected ? 'bg-green-600 text-white font-bold shadow-md' : 'text-gray-700 hover:bg-green-50' }}">
                        
                        <span>{{ $day }}</span>
                        
                        @if($hasRdv && !$isSelected)
                            <span class="absolute bottom-0 w-1 h-1 bg-green-500 rounded-full"></span>
                        @elseif($hasRdv && $isSelected)
                            <span class="absolute bottom-0 w-1 h-1 bg-white rounded-full"></span>
                        @endif
                    </a>
                @endfor
            </div>

            <div class="mt-8 flex items-center justify-between text-xs text-gray-500">
                <div class="flex items-center gap-2"><span class="w-3 h-3 bg-green-600 rounded-full"></span> Sélectionné</div>
                <div class="flex items-center gap-2"><span class="w-2 h-2 bg-green-500 rounded-full"></span> A des rendez-vous</div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">Programme du jour</h3>
                <span class="text-gray-500 text-sm">{{ ucfirst($selectedDate->translatedFormat('l, d F')) }}</span>
            </div>

            <div class="space-y-4">
                @forelse($rdvs as $rdv)
                    <div class="bg-green-50 border-l-4 border-green-600 rounded-lg p-4 flex items-center justify-between shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="bg-green-600 text-white px-3 py-1 rounded-md text-sm font-bold mt-1">
                                {{ \Carbon\Carbon::parse($rdv->date_heure)->format('H:i') }}
                            </div>
                            
                            <div>
                                <h4 class="text-lg font-bold text-gray-800">
                                    {{ $rdv->patient->user->nom ?? '' }} {{ $rdv->patient->user->prenom ?? 'Patient Inconnu' }}
                                </h4>
                                <p class="text-sm text-gray-600">Avec Dr. {{ $rdv->medecin->user->nom ?? '' }}</p>
                                <p class="text-xs text-gray-500 mt-1">Motif: {{ $rdv->motif ?? 'Non spécifié' }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow p-8 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Aucun rendez-vous prévu pour cette date.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</x-app-layout>