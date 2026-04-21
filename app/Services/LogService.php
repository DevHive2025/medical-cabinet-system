<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class LogService
{
    /**
     * Enregistrer une activité dans la base de données.
     *
     * @param string $action      L'action effectuée (ex: Création, Suppression, Connexion)
     * @param string $description Description détaillée de ce qui a été fait
     * @return void
     */
    public static function log($action, $description)
    {
        ActivityLog::create([
            'user_id'     => Auth::id(), // Récupère l'ID de l'utilisateur connecté
            'action'      => $action,
            'description' => $description,
            'ip_address'  => Request::ip(), // Récupère l'adresse IP (IPv4 ou IPv6)
            'user_agent'  => Request::userAgent(), // Récupère les infos du navigateur/système
        ]);
    }

    /**
     * Exemple d'une méthode spécifique pour les erreurs (Optionnel)
     */
    public static function error($description)
    {
        self::log('Erreur', $description);
    }
}