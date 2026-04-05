<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\Medecin;
use App\Models\RendezVous;
use App\Models\Consultation;
use App\Models\Ordonnance;
use App\Models\DossierMedical;

class MedicalActivitySeeder extends Seeder
{
    public function run(): void
    {
        
        $patient = Patient::first();
        $medecin = Medecin::first();

        if ($patient && $medecin) {
            
            DossierMedical::create([
                'patient_id' => $patient->id,
                'historique' => 'Aucun antécédent majeur.',
                'antecedents' => 'Grippe saisonnière en 2025',
                'allergies' => 'Pénicilline',
            ]);

            $rdv = RendezVous::create([
                'date_heure' => now()->addDays(2), 
                'statut' => 'confirme',
                'motif' => 'Consultation de routine - Douleurs thoraciques',
                'patient_id' => $patient->id,
                'medecin_id' => $medecin->id,
            ]);

            $consultation = Consultation::create([
                'date' => now(),
                'compte_rendu' => 'Le patient souffre de fatigue intense.',
                'diagnostic' => 'Anémie légère',
                'rendez_vous_id' => $rdv->id,
            ]);

            Ordonnance::create([
                'consultation_id' => $consultation->id,
                'date_emission' => now(),
                'contenu_medicaments' => 'Fer 50mg (1/jour), Vitamine C',
                'duree_traitement' => '3 mois',
            ]);
        }
    }
}