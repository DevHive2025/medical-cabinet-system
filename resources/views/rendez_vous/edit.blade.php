
<div class="container mt-4">
    <h2>Modifier le Rendez-vous</h2>

    <form action="{{ route('rendez-vous.update', $rdv->id) }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label class="form-label">Date et Heure</label>
            <input type="datetime-local" name="date_heure" class="form-control" value="{{ \Carbon\Carbon::parse($rdv->date_heure)->format('Y-m-d\TH:i') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Statut</label>
            <select name="statut" class="form-select" required>
                <option value="en attente" {{ $rdv->statut == 'en attente' ? 'selected' : '' }}>En attente</option>
                <option value="confirmé" {{ $rdv->statut == 'confirmé' ? 'selected' : '' }}>Confirmé</option>
                <option value="annulé" {{ $rdv->statut == 'annulé' ? 'selected' : '' }}>Annulé</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Motif</label>
            <textarea name="motif" class="form-control" rows="3">{{ $rdv->motif }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('rendez-vous.index') }}" class="btn btn-secondary">Retour</a>
    </form> 
</div>
