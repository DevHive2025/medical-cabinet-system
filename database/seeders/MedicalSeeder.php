<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medecin;
use App\Models\Patient;
use App\Models\RendezVous;
use App\Models\Consultation;
use App\Models\Ordonnance;

class MedicalSeeder extends Seeder
{
    public function run(): void
    {
        $medGenerale  = Medecin::where('specialite', 'Médecine Générale')->first();
        $medCardio    = Medecin::where('specialite', 'Cardiologie')->first();
        $medDermato   = Medecin::where('specialite', 'Dermatologie')->first();
        $medGyneco    = Medecin::where('specialite', 'Gynécologie')->first();
       
      

        $patients = Patient::all();

        // =============================================
        // RDV TERMINÉS avec Consultations + Ordonnances
        // =============================================

        // 1. Patient 0 - Médecine Générale
        $rdv1 = RendezVous::create(['date_heure' => now()->subDays(20), 'statut' => 'termine', 'motif' => 'Fièvre et toux', 'patient_id' => $patients[0]->id, 'medecin_id' => $medGenerale->id]);
        $con1 = Consultation::create(['rendez_vous_id' => $rdv1->id, 'date' => now()->subDays(20), 'symptomes' => 'Fièvre 39°, maux de gorge, toux sèche', 'diagnostic' => 'Grippe Saisonnière', 'compte_rendu' => 'État grippal sévère. Repos recommandé 5 jours.']);
        $ord1 = Ordonnance::create(['consultation_id' => $con1->id, 'reference' => 'ORD-2026-001', 'date_ordonnance' => now()->subDays(20)]);
        $ord1->lignes()->createMany([
            ['medicament' => 'Doliprane',  'dose' => '1000mg', 'posologie' => '3 fois/jour',            'duree' => '5 jours'],
            ['medicament' => 'Augmentin',  'dose' => '1g',     'posologie' => '2 fois/jour',            'duree' => '7 jours'],
            ['medicament' => 'Humex',      'dose' => 'Sirop',  'posologie' => '1 cuillère 3 fois/jour', 'duree' => '5 jours'],
        ]);

        // 2. Patient 1 - Cardiologie
        $rdv2 = RendezVous::create(['date_heure' => now()->subDays(15), 'statut' => 'termine', 'motif' => 'Vertiges et palpitations', 'patient_id' => $patients[1]->id, 'medecin_id' => $medCardio->id]);
        $con2 = Consultation::create(['rendez_vous_id' => $rdv2->id, 'date' => now()->subDays(15), 'symptomes' => 'Tension élevée 16/9, palpitations fréquentes', 'diagnostic' => 'Hypertension Artérielle', 'compte_rendu' => 'Nécessite suivi strict. Régime sans sel recommandé.']);
        $ord2 = Ordonnance::create(['consultation_id' => $con2->id, 'reference' => 'ORD-2026-002', 'date_ordonnance' => now()->subDays(15)]);
        $ord2->lignes()->createMany([
            ['medicament' => 'Amlor',      'dose' => '5mg',  'posologie' => '1 fois le matin',       'duree' => '3 mois'],
            ['medicament' => 'Lasilix',    'dose' => '40mg', 'posologie' => '1/2 comprimé par jour', 'duree' => '1 mois'],
        ]);

        // 3. Patient 2 - Pédiatrie
        $rdv3 = RendezVous::create(['date_heure' => now()->subDays(12), 'statut' => 'termine', 'motif' => 'Contrôle croissance', 'patient_id' => $patients[2]->id, 'medecin_id' => $medCardio->id]);
        $con3 = Consultation::create(['rendez_vous_id' => $rdv3->id, 'date' => now()->subDays(12), 'symptomes' => 'Aucun symptôme particulier', 'diagnostic' => 'Développement normal', 'compte_rendu' => 'Enfant en bonne santé. Vaccins à jour.']);
        $ord3 = Ordonnance::create(['consultation_id' => $con3->id, 'reference' => 'ORD-2026-003', 'date_ordonnance' => now()->subDays(12)]);
        $ord3->lignes()->createMany([
            ['medicament' => 'Vitamine D', 'dose' => '1000 UI', 'posologie' => '1 goutte/jour', 'duree' => '3 mois'],
            ['medicament' => 'Fer',        'dose' => '30mg',    'posologie' => '1 fois/jour',   'duree' => '2 mois'],
        ]);

        // 4. Patient 3 - Dermatologie
        $rdv4 = RendezVous::create(['date_heure' => now()->subDays(10), 'statut' => 'termine', 'motif' => 'Éruption cutanée', 'patient_id' => $patients[3]->id, 'medecin_id' => $medDermato->id]);
        $con4 = Consultation::create(['rendez_vous_id' => $rdv4->id, 'date' => now()->subDays(10), 'symptomes' => 'Rougeurs et démangeaisons sur les bras', 'diagnostic' => 'Eczema atopique', 'compte_rendu' => 'Appliquer la crème 2 fois/jour. Éviter les irritants.']);
        $ord4 = Ordonnance::create(['consultation_id' => $con4->id, 'reference' => 'ORD-2026-004', 'date_ordonnance' => now()->subDays(10)]);
        $ord4->lignes()->createMany([
            ['medicament' => 'Hydrocortisone crème', 'dose' => '1%',   'posologie' => '2 fois/jour', 'duree' => '2 semaines'],
            ['medicament' => 'Cetirizine',           'dose' => '10mg', 'posologie' => '1 le soir',   'duree' => '1 mois'],
        ]);

        // 5. Patient 4 - Neurologie
        $rdv5 = RendezVous::create(['date_heure' => now()->subDays(8), 'statut' => 'termine', 'motif' => 'Migraines fréquentes', 'patient_id' => $patients[4]->id, 'medecin_id' => $medGenerale->id]);
        $con5 = Consultation::create(['rendez_vous_id' => $rdv5->id, 'date' => now()->subDays(8), 'symptomes' => 'Maux de tête intenses, sensibilité à la lumière', 'diagnostic' => 'Migraine chronique', 'compte_rendu' => 'IRM recommandée. Éviter le stress et les écrans.']);
        $ord5 = Ordonnance::create(['consultation_id' => $con5->id, 'reference' => 'ORD-2026-005', 'date_ordonnance' => now()->subDays(8)]);
        $ord5->lignes()->createMany([
            ['medicament' => 'Imigrane',    'dose' => '50mg', 'posologie' => 'En cas de crise', 'duree' => '3 mois'],
            ['medicament' => 'Propranolol', 'dose' => '40mg', 'posologie' => '2 fois/jour',     'duree' => '3 mois'],
        ]);

        // 6. Patient 5 - Gynécologie
        $rdv6 = RendezVous::create(['date_heure' => now()->subDays(6), 'statut' => 'termine', 'motif' => 'Contrôle annuel', 'patient_id' => $patients[5]->id, 'medecin_id' => $medGyneco->id]);
        $con6 = Consultation::create(['rendez_vous_id' => $rdv6->id, 'date' => now()->subDays(6), 'symptomes' => 'Aucun symptôme', 'diagnostic' => 'Bilan gynécologique normal', 'compte_rendu' => 'Tout est normal. Prochain contrôle dans 1 an.']);
        $ord6 = Ordonnance::create(['consultation_id' => $con6->id, 'reference' => 'ORD-2026-006', 'date_ordonnance' => now()->subDays(6)]);
        $ord6->lignes()->createMany([
            ['medicament' => 'Acide folique', 'dose' => '400mcg', 'posologie' => '1 fois/jour', 'duree' => '3 mois'],
        ]);

        // 7. Patient 6 - Ophtalmologie
        $rdv7 = RendezVous::create(['date_heure' => now()->subDays(4), 'statut' => 'termine', 'motif' => 'Baisse de vision', 'patient_id' => $patients[6]->id, 'medecin_id' => $medDermato->id]);
        $con7 = Consultation::create(['rendez_vous_id' => $rdv7->id, 'date' => now()->subDays(4), 'symptomes' => 'Vision floue de loin, maux de tête', 'diagnostic' => 'Myopie légère', 'compte_rendu' => 'Prescription de lunettes recommandée. -1.5 diopties.']);
        $ord7 = Ordonnance::create(['consultation_id' => $con7->id, 'reference' => 'ORD-2026-007', 'date_ordonnance' => now()->subDays(4)]);
        $ord7->lignes()->createMany([
            ['medicament' => 'Larmes artificielles', 'dose' => 'Collyre', 'posologie' => '3 fois/jour', 'duree' => '1 mois'],
        ]);

        // 8. Patient 7 - Rhumatologie
        $rdv8 = RendezVous::create(['date_heure' => now()->subDays(2), 'statut' => 'termine', 'motif' => 'Douleurs articulaires', 'patient_id' => $patients[7]->id, 'medecin_id' => $medCardio->id]);
        $con8 = Consultation::create(['rendez_vous_id' => $rdv8->id, 'date' => now()->subDays(2), 'symptomes' => 'Douleurs genoux et hanches, raideur matinale', 'diagnostic' => 'Arthrose débutante', 'compte_rendu' => 'Kinésithérapie recommandée. Éviter les efforts intenses.']);
        $ord8 = Ordonnance::create(['consultation_id' => $con8->id, 'reference' => 'ORD-2026-008', 'date_ordonnance' => now()->subDays(2)]);
        $ord8->lignes()->createMany([
            ['medicament' => 'Ibuprofène',  'dose' => '400mg', 'posologie' => '3 fois/jour après repas', 'duree' => '2 semaines'],
            ['medicament' => 'Chondroïtine','dose' => '400mg', 'posologie' => '2 fois/jour',             'duree' => '3 mois'],
        ]);

        // =============================================
        // RDV À VENIR (confirmés et en attente)
        // =============================================
        RendezVous::create(['date_heure' => now()->addHours(2),  'statut' => 'confirme',   'motif' => 'Contrôle tension',         'patient_id' => $patients[8]->id,  'medecin_id' => $medCardio->id]);
        RendezVous::create(['date_heure' => now()->addHours(4),  'statut' => 'confirme',   'motif' => 'Suivi diabète',            'patient_id' => $patients[9]->id,  'medecin_id' => $medGenerale->id]);
        // RendezVous::create(['date_heure' => now()->addHours(6),  'statut' => 'en_attente', 'motif' => 'Douleurs dorsales',       'patient_id' => $patients[10]->id, 'medecin_id' => $medNeuro->id]);
        RendezVous::create(['date_heure' => now()->addDay(),     'statut' => 'en_attente', 'motif' => 'Résultats analyses',      'patient_id' => $patients[11]->id, 'medecin_id' => $medGenerale->id]);
        // RendezVous::create(['date_heure' => now()->addDays(2),   'statut' => 'confirme',   'motif' => 'Consultation routine',    'patient_id' => $patients[12]->id, 'medecin_id' => $medPediatrie->id]);
        RendezVous::create(['date_heure' => now()->addDays(3),   'statut' => 'en_attente', 'motif' => 'Problème peau',           'patient_id' => $patients[13]->id, 'medecin_id' => $medDermato->id]);
        // RendezVous::create(['date_heure' => now()->addDays(4),   'statut' => 'confirme',   'motif' => 'Contrôle vue',            'patient_id' => $patients[14]->id, 'medecin_id' => $medOphtalmo->id]);
        RendezVous::create(['date_heure' => now()->addDays(5),   'statut' => 'en_attente', 'motif' => 'Suivi traitement',        'patient_id' => $patients[0]->id,  'medecin_id' => $medCardio->id]);
        RendezVous::create(['date_heure' => now()->addDays(6),   'statut' => 'confirme',   'motif' => 'Bilan annuel',            'patient_id' => $patients[1]->id,  'medecin_id' => $medGyneco->id]);
        // RendezVous::create(['date_heure' => now()->addDays(7),   'statut' => 'en_attente', 'motif' => 'Douleurs articulaires',   'patient_id' => $patients[2]->id,  'medecin_id' => $medRhumato->id]);

        // =============================================
        // RDV ANNULÉS
        // =============================================
        RendezVous::create(['date_heure' => now()->subDays(30), 'statut' => 'annule', 'motif' => 'Annulé par patient',    'patient_id' => $patients[3]->id, 'medecin_id' => $medGenerale->id]);
        RendezVous::create(['date_heure' => now()->subDays(25), 'statut' => 'annule', 'motif' => 'Annulé par médecin',   'patient_id' => $patients[4]->id, 'medecin_id' => $medCardio->id]);
    }
}
