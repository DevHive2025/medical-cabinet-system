<!DOCTYPE html>
<html>
<head>
    <title>Confirmation de Rendez-vous</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Bonjour,</h2>
    
    <p>Vous avez demandé un rendez-vous médical avec le <strong>Dr. {{ $rdv->medecin->user->nom ?? '' }}</strong>.</p>
    
    <p><strong>Date et Heure :</strong> {{ \Carbon\Carbon::parse($rdv->date_heure)->format('d/m/Y à H:i') }}</p>
    
    <p>Pour valider ce rendez-vous, veuillez cliquer sur le bouton ci-dessous :</p>
    
    <a href="{{ $urlConfirmation }}" style="display: inline-block; padding: 10px 20px; background-color: #2563eb; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold;">
        Confirmer mon rendez-vous
    </a>

    <p><br>Si vous n'êtes pas à l'origine de cette demande, vous pouvez ignorer cet email.</p>
</body>
</html>