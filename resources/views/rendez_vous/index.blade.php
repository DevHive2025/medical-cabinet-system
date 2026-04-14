<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Liste des Rendez-vous</h2>
        <a href="{{ route('rendez-vous.create') }}" class="btn btn-primary">Nouveau Rendez-vous</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Date & Heure</th>
                        <th>Patient</th>
                        <th>Médecin</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rdvs as $rdv)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($rdv->date_heure)->format('d/m/Y H:i') }}</td>
                        
                        <td>{{ $rdv->patient->nom ?? 'Inconnu' }} {{ $rdv->patient->prenom ?? '' }}</td>
                        <td>Dr. {{ $rdv->medecin->name ?? 'Inconnu' }}</td>
                        
                        <td>
                            @if($rdv->statut == 'confirmé') 
                                <span class="badge bg-success">Confirmé</span>
                            @elseif($rdv->statut == 'annulé') 
                                <span class="badge bg-danger">Annulé</span>
                            @else 
                                <span class="badge bg-warning text-dark">En attente</span>
                            @endif
                        </td>
                        
                        <td>
                            <a href="{{ route('rendez-vous.edit', $rdv->id) }}" class="btn btn-sm btn-info text-white">Modifier</a>
                            
                            @if($rdv->statut != 'annulé')
                            <form action="{{ route('rendez-vous.annuler', $rdv->id) }}" method="POST" class="d-inline">
                                @csrf 
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Voulez-vous vraiment annuler ce rendez-vous ?')">Annuler</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Aucun rendez-vous trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div> 
    </div>
</div>
