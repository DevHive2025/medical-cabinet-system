<x-app-layout>
<div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-sm mt-6 border border-gray-100">
    
    <div class="flex justify-between items-center mb-6 border-b pb-4">
        <h2 class="text-2xl font-bold text-gray-800">Modifier le Rendez-vous</h2>
        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">Mode Édition</span>
    </div>

    <form action="{{ route('rendez-vous.update', $rdv->id) }}" method="POST" id="rdvForm">
        @csrf
        @method('PUT')
        <input type="hidden" name="date_heure" id="date_heure_input" value="{{ $currentDate }} {{ $currentTime }}:00" required>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">Spécialité</label>
                <select id="specialite_select" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Choisissez une spécialité --</option>
                    @foreach($specialites as $specialite)
                        <option value="{{ $specialite }}" {{ $currentSpecialite == $specialite ? 'selected' : '' }}>
                            {{ $specialite }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div id="medecin_container">
                <label class="block text-sm font-medium text-gray-700 mb-2">Médecin</label>
                <select name="medecin_id" id="medecin_select" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">-- Choisissez un médecin --</option>
                    @foreach($medecins as $medecin)
                        <option value="{{ $medecin->id }}" {{ $rdv->medecin_id == $medecin->id ? 'selected' : '' }}>
                            Dr. {{ $medecin->user->nom ?? '' }} {{ $medecin->user->prenom ?? '' }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div id="calendar_container" class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-2">Sélectionnez une date</label>
            <div id="days_scroll" class="flex overflow-x-auto gap-3 pb-4 scrollbar-thin">
                </div>
        </div>

        <div id="time_slots_container" class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-3">Horaires disponibles</label>
            <div id="slots_grid" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                </div>
        </div>

        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-2">Motif de la visite</label>
            <textarea name="motif" rows="4" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3">{{ old('motif', $rdv->motif) }}</textarea>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" id="submit_btn" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                Enregistrer les modifications
            </button>
            <a href="{{ route('rendez-vous.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Annuler
            </a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const specialiteSelect = document.getElementById('specialite_select');
    const medecinContainer = document.getElementById('medecin_container');
    const medecinSelect = document.getElementById('medecin_select');
    const calendarContainer = document.getElementById('calendar_container');
    const daysScroll = document.getElementById('days_scroll');
    const timeSlotsContainer = document.getElementById('time_slots_container');
    const slotsGrid = document.getElementById('slots_grid');
    const dateHeureInput = document.getElementById('date_heure_input');
    const submitBtn = document.getElementById('submit_btn');

    // Variables initialisées avec les données existantes
    let selectedDate = "{{ $currentDate }}";
    let selectedTime = "{{ $currentTime }}";
    const currentRdvId = "{{ $rdv->id }}";

    // 1. Initialisation au chargement de la page
    generateCalendar();
    loadTimeSlots(selectedDate, medecinSelect.value);

    // 2. CASCADE : Changement de Spécialité -> Reset tout
    specialiteSelect.addEventListener('change', async function() {
        medecinSelect.innerHTML = '<option value="">-- Choisissez un médecin --</option>';
        resetEverything(); // Oblige à tout refaire
        
        if (!this.value) {
            medecinContainer.classList.add('hidden');
            return;
        }

        const response = await fetch(`{{ route('api.medecins') }}?specialite=${this.value}`);
        const medecins = await response.json();
        medecins.forEach(med => {
            medecinSelect.innerHTML += `<option value="${med.id}">Dr. ${med.nom} ${med.prenom}</option>`;
        });
        medecinContainer.classList.remove('hidden');
    });

    // 3. CASCADE : Changement de Médecin -> Reset Date et Heure
    medecinSelect.addEventListener('change', function() {
        resetEverything(); // Oblige à choisir une nouvelle date/heure
        if (this.value) {
            generateCalendar();
        }
    });

    // Générateur de calendrier (identique à create)
    function generateCalendar() {
        calendarContainer.classList.remove('hidden');
        daysScroll.innerHTML = '';
        
        let today = new Date();
        for (let i = 0; i <= 14; i++) {
            let nextDay = new Date(today);
            nextDay.setDate(today.getDate() + i);
            
            if(nextDay.getDay() === 0) continue; 

            let dateString = nextDay.toISOString().split('T')[0];
            let dayName = nextDay.toLocaleDateString('fr-FR', { weekday: 'short' });
            let dayNum = nextDay.getDate();
            let monthName = nextDay.toLocaleDateString('fr-FR', { month: 'short' });

            let isSelected = (dateString === selectedDate);
            let btnClass = isSelected 
                ? 'border-green-600 bg-green-200' 
                : 'border-green-200 bg-green-50 hover:bg-green-100';

            let btn = document.createElement('button');
            btn.type = 'button';
            btn.className = `flex-shrink-0 flex flex-col items-center justify-center w-20 h-24 border-2 text-green-700 rounded-xl transition focus:outline-none day-btn ${btnClass}`;
            btn.dataset.date = dateString;
            btn.innerHTML = `<span class="text-sm uppercase font-semibold">${dayName}</span>
                             <span class="text-2xl font-bold my-1">${dayNum}</span>
                             <span class="text-xs">${monthName}</span>`;
            
            btn.addEventListener('click', function() {
                document.querySelectorAll('.day-btn').forEach(b => {
                    b.classList.remove('border-green-600', 'bg-green-200');
                    b.classList.add('border-green-200', 'bg-green-50');
                });
                this.classList.remove('border-green-200', 'bg-green-50');
                this.classList.add('border-green-600', 'bg-green-200');
                
                selectedDate = this.dataset.date;
                selectedTime = null; // Changement de date = réinitialiser l'heure
                updateHiddenInput();
                loadTimeSlots(selectedDate, medecinSelect.value);
            });

            daysScroll.appendChild(btn);
        }
    }

    // Charger les créneaux
    async function loadTimeSlots(date, medecinId) {
        timeSlotsContainer.classList.remove('hidden');
        slotsGrid.innerHTML = '<div class="col-span-full text-center text-gray-500 py-4">Chargement...</div>';
        
        // On envoie 'exclude_rdv_id' pour que l'heure actuelle du patient reste VERTE !
        const response = await fetch(`{{ route('api.creneaux') }}?date=${date}&medecin_id=${medecinId}&exclude_rdv_id=${currentRdvId}`);
        const slots = await response.json();

        slotsGrid.innerHTML = '';
        let allFull = true;

        slots.forEach(slot => {
            let btn = document.createElement('button');
            btn.type = 'button';
            
            if (slot.disponible) {
                allFull = false;
                let isSelected = (slot.heure === selectedTime);
                
                // Si c'est l'heure sélectionnée, on la met en bleu, sinon en vert
                let btnClass = isSelected 
                    ? 'border-blue-600 bg-blue-50 text-blue-700 ring-2 ring-blue-500' 
                    : 'border-green-300 text-green-700 bg-green-50 hover:bg-green-100';

                btn.className = `time-btn border rounded-lg p-3 text-center transition font-medium disponible ${btnClass}`;
                btn.innerText = slot.heure;
                
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.time-btn.disponible').forEach(b => {
                        b.classList.remove('border-blue-600', 'bg-blue-50', 'text-blue-700', 'ring-2', 'ring-blue-500');
                        b.classList.add('border-green-300', 'text-green-700', 'bg-green-50');
                    });
                    
                    this.classList.remove('border-green-300', 'text-green-700', 'bg-green-50');
                    this.classList.add('border-blue-600', 'bg-blue-50', 'text-blue-700', 'ring-2', 'ring-blue-500');
                    
                    selectedTime = slot.heure;
                    updateHiddenInput();
                });
            } else {
                btn.className = `border border-red-200 text-red-500 bg-red-50 rounded-lg p-3 text-center opacity-50 cursor-not-allowed line-through`;
                btn.innerText = slot.heure;
                btn.disabled = true;
            }
            slotsGrid.appendChild(btn);
        });

        if(allFull) {
            let dayBtn = document.querySelector(`.day-btn[data-date="${date}"]`);
            if(dayBtn) {
                dayBtn.className = `flex-shrink-0 flex flex-col items-center justify-center w-20 h-24 border-2 border-red-200 bg-red-50 text-red-500 rounded-xl opacity-60 cursor-not-allowed`;
                dayBtn.disabled = true;
            }
            slotsGrid.innerHTML = '<div class="col-span-full text-center text-red-500 font-medium py-4">Créneaux réservés.</div>';
        }
    }

    // Forcer l'utilisateur à refaire ses choix
    function resetEverything() {
        calendarContainer.classList.add('hidden');
        timeSlotsContainer.classList.add('hidden');
        selectedDate = null;
        selectedTime = null;
        updateHiddenInput();
    }

    function updateHiddenInput() {
        if (selectedDate && selectedTime) {
            dateHeureInput.value = `${selectedDate} ${selectedTime}:00`;
            submitBtn.disabled = false;
        } else {
            dateHeureInput.value = '';
            submitBtn.disabled = true; // Bloque le bouton si l'heure n'est pas choisie
        }
    }
});
</script>
</x-app-layout>