<div class="container mt-4">
    <h2>Prendre un nouveau Rendez-vous</h2>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('rendez-vous.store') }}" method="POST" class="mt-3">
        @csrf
        
        <div class="mb-3">
            <label class="form-label">Patient</label>
            <select name="patient_id" class="form-select" required>
                <option value="">Sélectionnez un patient</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->nom }} {{ $patient->prenom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Médecin</label>
            <select name="medecin_id" class="form-select" required>
                <option value="">Sélectionnez un médecin</option>
                @foreach($medecins as $medecin)
                    <option value="{{ $medecin->id }}">Dr. {{ $medecin->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Date et Heure</label>
            <input type="datetime-local" name="date_heure" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Motif (Optionnel)</label>
            <textarea name="motif" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer le RDV</button>
        <a href="{{ route('rendez-vous.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
