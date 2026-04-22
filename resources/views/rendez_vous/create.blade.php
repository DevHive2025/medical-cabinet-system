<x-app-layout>
<div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-sm mt-6 border border-gray-100">
    
    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">Prendre un Rendez-vous</h2>

    <form action="{{ route('rendez-vous.store') }}" method="POST" id="rdvForm">
        @csrf
        <input type="hidden" name="date_heure" id="date_heure_input" required>
        @if(auth()->user()->role === 'secretaire')
        <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-2">Sélectionner le patient</label>
            
            <select name="patient_id" id="patient_select" required autocomplete="off" placeholder="-- Chercher un patient (Nom, Prénom ou CIN) --" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="">-- Chercher un patient (Nom, Prénom ou CIN) --</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">
                        {{ $patient->user->nom ?? '' }} {{ $patient->user->prenom ?? '' }} - CIN: {{ $patient->cin ?? 'Non renseigné' }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Spécialité</label>
                <select id="specialite_select" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Choisissez une spécialité --</option>
                    @foreach($specialites as $specialite)
                        <option value="{{ $specialite }}">{{ $specialite }}</option>
                    @endforeach
                </select>
            </div>

            <div id="medecin_container" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">Médecin</label>
                <select name="medecin_id" id="medecin_select" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">-- Choisissez un médecin --</option>
                </select>
            </div>
        </div>

        <div id="calendar_container" class="mb-8 hidden">
            <label class="block text-sm font-medium text-gray-700 mb-2">Sélectionnez une date (30 prochains jours)</label>
            <div id="days_scroll" class="flex overflow-x-auto gap-3 pb-4 scrollbar-thin">
                </div>
        </div>

        <div id="time_slots_container" class="mb-8 hidden">
            <label class="block text-sm font-medium text-gray-700 mb-3">Créneaux horaires disponibles</label>
            <div id="slots_grid" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                </div>
        </div>

        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-2">Motif de la visite</label>
            <textarea name="motif" rows="4" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3" placeholder="Veuillez décrire vos symptômes ou la raison de votre visite..."></textarea>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" id="submit_btn" disabled class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed w-full md:w-auto">
                Confirmer le rendez-vous
            </button>
            <button type="reset" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Clair
            </button>
        </div>
    </form>
</div>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.default.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
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

    let selectedDate = null;
    let selectedTime = null;
    const selectElement = document.getElementById('patient_select');
        
        if (selectElement) {
            // Initialisation de la barre de recherche intelligente
            new TomSelect(selectElement, {
                create: false, // Empêche de créer un nouveau patient depuis cette barre
                sortField: {
                    field: "text",
                    direction: "asc" // Trie la liste par ordre alphabétique
                },
                placeholder: "Tapez un nom, prénom ou CIN..."
            });
        }

    // 1. Changement de Spécialité -> Charger Médecins
    specialiteSelect.addEventListener('change', async function() {
        resetCalendar();
        medecinSelect.innerHTML = '<option value="">-- Choisissez un médecin --</option>';
        
        if (!this.value) {
            medecinContainer.classList.add('hidden');
            return;
        }

        // Appel AJAX vers notre route
        const response = await fetch(`{{ route('api.medecins') }}?specialite=${this.value}`);
        const medecins = await response.json();

        medecins.forEach(med => {
            medecinSelect.innerHTML += `<option value="${med.id}">${med.prenom} ${med.nom}</option>`;
        });
        
        medecinContainer.classList.remove('hidden');
    });

    // 2. Changement de Médecin -> Générer Calendrier (14 prochains jours)
    medecinSelect.addEventListener('change', function() {
        resetCalendar();
        if (!this.value) return;

        calendarContainer.classList.remove('hidden');
        daysScroll.innerHTML = '';
        
        // Générer les 14 jours à partir de demain
        let today = new Date();
        for (let i = 0; i <= 14; i++) {
            let nextDay = new Date(today);
            nextDay.setDate(today.getDate() + i);
            
            // Ignorer les dimanches (optionnel)
            if(nextDay.getDay() === 0) continue; 

            let year = nextDay.getFullYear();
            let month = String(nextDay.getMonth() + 1).padStart(2, '0');
            let day = String(nextDay.getDate()).padStart(2, '0');
            let dateString = `${year}-${month}-${day}`;
            let dayName = nextDay.toLocaleDateString('fr-FR', { weekday: 'short' });
            let dayNum = nextDay.getDate();
            let monthName = nextDay.toLocaleDateString('fr-FR', { month: 'short' });

            let btn = document.createElement('button');
            btn.type = 'button';
            // Vert clair par défaut pour les jours cliquables
            btn.className = `flex-shrink-0 flex flex-col items-center justify-center w-20 h-24 border-2 border-green-200 bg-green-50 text-green-700 rounded-xl hover:bg-green-100 transition focus:outline-none day-btn`;
            btn.dataset.date = dateString;
            btn.innerHTML = `<span class="text-sm uppercase font-semibold">${dayName}</span>
                             <span class="text-2xl font-bold my-1">${dayNum}</span>
                             <span class="text-xs">${monthName}</span>`;
            
            btn.addEventListener('click', function() {
                // Style actif
                document.querySelectorAll('.day-btn').forEach(b => b.classList.remove('border-green-600', 'bg-green-200'));
                this.classList.add('border-green-600', 'bg-green-200');
                
                selectedDate = this.dataset.date;
                selectedTime = null;
                updateHiddenInput();
                loadTimeSlots(selectedDate, medecinSelect.value);
            });

            daysScroll.appendChild(btn);
        }
    });

    // 3. Charger les créneaux pour un jour donné
    async function loadTimeSlots(date, medecinId) {
        timeSlotsContainer.classList.remove('hidden');
        slotsGrid.innerHTML = '<div class="col-span-full text-center text-gray-500 py-4">Chargement des horaires...</div>';
        
        const response = await fetch(`{{ route('api.creneaux') }}?date=${date}&medecin_id=${medecinId}`);
        const slots = await response.json();

        slotsGrid.innerHTML = '';

        // Vérifier si tout est plein
        let allFull = true;

        slots.forEach(slot => {
            let btn = document.createElement('button');
            btn.type = 'button';
            
            if (slot.disponible) {
                allFull = false;
                // Vert pour les créneaux libres (comme demandé)
                btn.className = `time-btn border border-green-300 text-green-700 bg-green-50 rounded-lg p-3 text-center hover:bg-green-100 transition font-medium`;
                btn.innerText = slot.heure;
                
                btn.addEventListener('click', function() {
                    // Style cliqué (Bleu comme sur votre image)
                    document.querySelectorAll('.time-btn.disponible').forEach(b => {
                        b.classList.remove('border-blue-600', 'bg-blue-50', 'text-blue-700', 'ring-2', 'ring-blue-500');
                        b.classList.add('border-green-300', 'text-green-700', 'bg-green-50');
                    });
                    
                    this.classList.remove('border-green-300', 'text-green-700', 'bg-green-50');
                    this.classList.add('disponible', 'border-blue-600', 'bg-blue-50', 'text-blue-700', 'ring-2', 'ring-blue-500');
                    
                    selectedTime = slot.heure;
                    updateHiddenInput();
                });
                btn.classList.add('disponible');
            } else {
                // Rouge et bloqué pour les créneaux réservés
                btn.className = `border border-red-200 text-red-500 bg-red-50 rounded-lg p-3 text-center opacity-50 cursor-not-allowed line-through`;
                btn.innerText = slot.heure;
                btn.disabled = true;
            }
            slotsGrid.appendChild(btn);
        });

        // Si tous les créneaux sont pris, on met le bouton du jour en rouge
        if(allFull) {
            let dayBtn = document.querySelector(`.day-btn[data-date="${date}"]`);
            if(dayBtn) {
                dayBtn.className = `flex-shrink-0 flex flex-col items-center justify-center w-20 h-24 border-2 border-red-200 bg-red-50 text-red-500 rounded-xl opacity-60 cursor-not-allowed`;
                dayBtn.disabled = true;
            }
            slotsGrid.innerHTML = '<div class="col-span-full text-center text-red-500 font-medium py-4">Tous les créneaux sont réservés pour ce jour.</div>';
        }
    }

    // Fonction de mise à jour du champ caché envoyé au serveur
    function updateHiddenInput() {
        if (selectedDate && selectedTime) {
            dateHeureInput.value = `${selectedDate} ${selectedTime}:00`;
            submitBtn.disabled = false;
        } else {
            dateHeureInput.value = '';
            submitBtn.disabled = true;
        }
    }

    // Fonction pour réinitialiser les vues inférieures
    function resetCalendar() {
        calendarContainer.classList.add('hidden');
        timeSlotsContainer.classList.add('hidden');
        selectedDate = null;
        selectedTime = null;
        updateHiddenInput();
    }
});
</script>
</x-app-layout>