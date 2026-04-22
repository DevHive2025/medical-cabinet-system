<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RendezVous;
use App\Mail\RappelRdvMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendRdvReminders extends Command
{
    // Le nom de la commande à taper dans le terminal
    protected $signature = 'rdv:send-reminders';
    protected $description = 'Envoie un email de rappel aux patients 24h avant leur RDV';

    public function handle()
    {
        // 1. On récupère la date de demain (ex: si on est le 21 avril, $demain sera le 22 avril)
        $demain = \Carbon\Carbon::tomorrow();

        // 2. On cherche les RDV confirmés pour cette date précise
        // On utilise whereDate pour ignorer l'heure et ne comparer que le jour
        $rdvs = RendezVous::with(['patient.user', 'medecin.user'])
            ->where('statut', 'confirme')
            ->whereDate('date_heure', $demain) 
            ->where('rappel_envoye', false) // Sécurité pour ne pas envoyer deux fois
            ->get();

        $count = 0;

        foreach ($rdvs as $rdv) {
            \Illuminate\Support\Facades\Mail::to($rdv->patient->user->email)->send(new \App\Mail\RappelRdvMail($rdv));
            
            // On marque comme envoyé
            $rdv->update(['rappel_envoye' => true]);
            $count++;
        }

        $this->info("$count rappels envoyés pour la date du " . $demain->format('d/m/Y'));
    }
}