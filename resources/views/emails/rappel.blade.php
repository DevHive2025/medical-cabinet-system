<!DOCTYPE html>
<html>
<head>
    <title>Rappel de Rendez-vous</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">

    <h2>Bonjour {{ $rdv->patient->user->prenom }} {{ $rdv->patient->user->nom }},</h2>

    <p>Nous vous rappelons que vous avez un rendez-vous prévu pour demain :</p>

    <div style="background-color: #f3f4f6; padding: 15px; border-radius: 8px;">
        <p><strong>Date et Heure :</strong> {{ \Carbon\Carbon::parse($rdv->date_heure)->format('d/m/Y à H:i') }}</p>
        <p><strong>Médecin :</strong> Dr. {{ $rdv->medecin->user->nom }} {{ $rdv->medecin->user->prenom }}</p>
        <p><strong>Spécialité :</strong> {{ $rdv->medecin->specialite }}</p>
    </div>

    <p>Merci de vous présenter à la clinique environ 10 minutes avant l'heure prévue.</p>

    <p>Cordialement,<br>Le secrétariat de la clinique.</p>

</body>
</html>