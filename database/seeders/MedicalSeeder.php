<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Medecin;
use App\Models\Patient;
use App\Models\RendezVous;
use App\Models\Consultation;
use App\Models\Ordonnance;
use App\Models\OrdonnanceLigne;

class MedicalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $medecin = Medecin::where('specialite', 'Médecine Générale')->first();
        $patients = Patient::all();

        $rdv1 = RendezVous::create([
            'date_heure' => now()->subDays(2), 'statut' => 'termine',
            'motif' => 'Fièvre et toux', 'patient_id' => $patients[0]->id, 'medecin_id' => $medecin->id
        ]);
        $con1 = Consultation::create([
            'rendez_vous_id' => $rdv1->id, 'date' => now()->subDays(2),
            'symptomes' => 'Fièvre (39°), maux de gorge', 'compte_rendu' => 'Etat grippal sévère', 'diagnostic' => 'Grippe Saisonnière'
        ]);
        $ord1 = Ordonnance::create(['consultation_id' => $con1->id, 'reference' => 'ORD-2026-001', 'date_ordonnance' => now()->subDays(2)]);
        $ord1->lignes()->createMany([
            ['medicament' => 'Doliprane', 'dose' => '1000mg', 'posologie' => '3 fois/jour', 'duree' => '5 jours'],
            ['medicament' => 'Augmentin', 'dose' => '1g', 'posologie' => '2 fois/jour', 'duree' => '7 jours'],
            ['medicament' => 'Humex', 'dose' => 'Sirop', 'posologie' => '1 cuillère 3 fois/jour', 'duree' => '5 jours'],
        ]);

        $rdv2 = RendezVous::create([
            'date_heure' => now()->subDays(1), 'statut' => 'termine',
            'motif' => 'Vertiges', 'patient_id' => $patients[1]->id, 'medecin_id' => $medecin->id
        ]);
        $con2 = Consultation::create([
            'rendez_vous_id' => $rdv2->id, 'date' => now()->subDays(1),
            'symptomes' => 'Tension élevée (16/9)', 'compte_rendu' => 'Nécessite un suivi strict', 'diagnostic' => 'Hypertension Artérielle'
        ]);
        $ord2 = Ordonnance::create(['consultation_id' => $con2->id, 'reference' => 'ORD-2026-002', 'date_ordonnance' => now()->subDays(1)]);
        $ord2->lignes()->createMany([
            ['medicament' => 'Amlor', 'dose' => '5mg', 'posologie' => '1 fois le matin', 'duree' => '3 mois'],
            ['medicament' => 'Lasilix', 'dose' => '40mg', 'posologie' => '1/2 comprimé par jour', 'duree' => '1 mois'],
        ]);

        RendezVous::create([
            'date_heure' => now()->addDays(1), 'statut' => 'en_attente',
            'motif' => 'Contrôle', 'patient_id' => $patients[2]->id, 'medecin_id' => $medecin->id
        ]);
        RendezVous::create([
            'date_heure' => now()->addDays(2), 'statut' => 'en_attente',
            'motif' => 'Résultats d\'analyses', 'patient_id' => $patients[3]->id, 'medecin_id' => $medecin->id
        ]);
    }
}
