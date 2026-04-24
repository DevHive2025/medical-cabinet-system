<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ActivityLog;
use App\Models\User;

class ActivityLogSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        $logs = [
            [
                'action' => 'login',
                'description' => 'Connexion réussie au système',
            ],
            [
                'action' => 'create_patient',
                'description' => 'Création d’un nouveau patient: Omar Amrani',
            ],
            [
                'action' => 'update_patient',
                'description' => 'Mise à jour des informations du patient: Khadija Bennani',
            ],
            [
                'action' => 'create_consultation',
                'description' => 'Nouvelle consultation ajoutée pour le patient Mohamed Zouhair',
            ],
            [
                'action' => 'create_rendez_vous',
                'description' => 'Rendez-vous planifié pour Sanaa Chami le 2026-05-02 à 10:30',
            ],
            [
                'action' => 'cancel_rendez_vous',
                'description' => 'Annulation du rendez-vous de Rachid Ouali',
            ],
            [
                'action' => 'create_ordonnance',
                'description' => 'Ordonnance créée pour Imane Tazi',
            ],
            [
                'action' => 'download_pdf',
                'description' => 'Téléchargement du PDF de consultation (ID: 12)',
            ],
            [
                'action' => 'logout',
                'description' => 'Déconnexion de l’utilisateur',
            ],
            [
                'action' => 'delete_patient',
                'description' => 'Suppression du patient: ancien dossier archivé',
            ],
        ];

        foreach ($logs as $log) {
            ActivityLog::create([
                'user_id'    => $users->random()->id ?? null,
                'action'     => $log['action'],
                'description'=> $log['description'],
                'ip_address' => fake()->ipv4(),
                'user_agent' => fake()->userAgent(),
            ]);
        }
    }
}