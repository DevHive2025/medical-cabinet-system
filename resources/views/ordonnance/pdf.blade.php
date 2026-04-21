<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { border-bottom: 2px solid #16a34a; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { color: #16a34a; font-size: 18px; margin: 0; }
        .header p { margin: 3px 0; color: #666; }
        .ref { text-align: right; font-size: 11px; color: #666; }
        .patient { background: #f3f4f6; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        .patient p { margin: 3px 0; }
        .title { font-size: 14px; font-weight: bold; color: #333; border-bottom: 1px solid #ddd; padding-bottom: 5px; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #16a34a; color: white; padding: 8px; text-align: left; font-size: 11px; }
        td { padding: 8px; border-bottom: 1px solid #eee; font-size: 11px; }
        tr:nth-child(even) { background: #f9fafb; }
        .signature { margin-top: 40px; text-align: right; }
        .signature p { margin: 3px 0; }
        .footer { margin-top: 30px; border-top: 1px solid #ddd; padding-top: 10px; font-size: 10px; color: #999; text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <div style="display: flex; justify-content: space-between;">
            <div>
                <h1>Dr. {{ $ordonnance->consultation->rendezVous->medecin->user->nom }} {{ $ordonnance->consultation->rendezVous->medecin->user->prenom }}</h1>
                <p>{{ $ordonnance->consultation->rendezVous->medecin->specialite }}</p>
                <p>Tél: {{ $ordonnance->consultation->rendezVous->medecin->cabinet_telephone }}</p>
            </div>
            <div class="ref">
                <p><strong>Réf:</strong> {{ $ordonnance->reference }}</p>
                <p><strong>Date:</strong> {{ $ordonnance->date_ordonnance }}</p>
            </div>
        </div>
    </div>

    <div class="patient">
        <p><strong>Patient:</strong> {{ $ordonnance->consultation->rendezVous->patient->user->nom }} {{ $ordonnance->consultation->rendezVous->patient->user->prenom }}</p>
        <p><strong>Diagnostic:</strong> {{ $ordonnance->consultation->diagnostic }}</p>
    </div>

    <div class="title">ORDONNANCE MÉDICALE</div>

    <table>
        <thead>
            <tr>
                <th>Médicament</th>
                <th>Posologie</th>
                <th>Durée</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ordonnance->lignes as $ligne)
            <tr>
                <td>{{ $ligne->medicament }}</td>
                <td>{{ $ligne->posologie }}</td>
                <td>{{ $ligne->duree }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature">
        <p>Fait le {{ $ordonnance->date_ordonnance }}</p>
        <br><br>
        <p><strong>Dr. {{ $ordonnance->consultation->rendezVous->medecin->user->nom }} {{ $ordonnance->consultation->rendezVous->medecin->user->prenom }}</strong></p>
        <p>{{ $ordonnance->consultation->rendezVous->medecin->specialite }}</p>
    </div>

    <div class="footer">
        Cabinet Médical — Ordonnance valable 3 mois
    </div>

</body>
</html>
