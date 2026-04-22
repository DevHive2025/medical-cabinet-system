<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Consultation PDF</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #16a34a; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { color: #16a34a; font-size: 20px; }
        .section { margin-bottom: 15px; }
        .section h3 { background: #f0fdf4; color: #16a34a; padding: 5px 10px; font-size: 13px; }
        .section p { padding: 5px 10px; }
        .footer { text-align: center; margin-top: 40px; font-size: 11px; color: #999; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏥 Cabinet Médical</h1>
        <p>Compte-rendu de Consultation</p>
    </div>

    <div class="section">
        <h3>Informations</h3>
        <p><strong>Patient :</strong> {{ $consultation->rendezVous->patient->user->nom }} {{ $consultation->rendezVous->patient->user->prenom }}</p>
        <p><strong>Médecin :</strong> Dr. {{ $consultation->rendezVous->medecin->user->nom }} {{ $consultation->rendezVous->medecin->user->prenom }}</p>
        <p><strong>Date :</strong> {{ $consultation->date }}</p>
    </div>

    <div class="section">
        <h3>Diagnostic</h3>
        <p>{{ $consultation->diagnostic }}</p>
    </div>

    <div class="section">
        <h3>Symptômes</h3>
        <p>{{ $consultation->symptomes }}</p>
    </div>

    <div class="section">
        <h3>Compte Rendu</h3>
        <p>{{ $consultation->compte_rendu }}</p>
    </div>

    <div class="footer">
        <p>Document généré le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>
</body>
</html>
