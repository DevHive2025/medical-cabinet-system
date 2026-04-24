<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Patient;
use App\Models\Medecin;
use App\Models\RendezVous;
use App\Models\Consultation;
use App\Models\Ordonnance;
use App\Models\OrdonnanceLigne;

class OrdonnanceTest extends TestCase
{
    use RefreshDatabase;

    private function createConsultation()
    {
        $patientUser = User::factory()->create(['role' => 'patient']);
        $patient = Patient::create([
            'user_id' => $patientUser->id,
            'cin' => 'TESTPAT',
            'genre' => 'Homme',
            'date_naissance' => '1990-01-01',
            'telephone' => '0600000000',
        ]);

        $medecinUser = User::factory()->create(['role' => 'medecin']);
        $medecin = Medecin::create([
            'user_id' => $medecinUser->id,
            'specialite' => 'Generaliste',
            'cabinet_telephone' => '0522000000', 
        ]);

        $rdv = RendezVous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'date_heure' => '2026-05-10 10:00:00',
            'motif' => 'Consultation test',
            'statut' => 'termine'
        ]);

        return Consultation::create([
            'rendez_vous_id' => $rdv->id,
            'observations' => 'Observation test',
            'date' => now()->toDateString(),
        ]);
    }

    public function test_medecin_can_create_ordonnance_with_lignes()
    {
        $medecinUser = User::factory()->create(['role' => 'medecin']);
        $consultation = $this->createConsultation();

        $ordonnanceData = [
            'consultation_id' => $consultation->id,
            'lignes' => [
                [
                    'medicament' => 'Doliprane',
                    'dose' => '1000mg',
                    'posologie' => '1 matin, 1 soir',
                    'duree' => '3 jours',
                ],
                [
                    'medicament' => 'Amoxicilline',
                    'dose' => '500mg',
                    'posologie' => '1 matin, 1 midi, 1 soir',
                    'duree' => '7 jours',
                ]
            ]
        ];

        $response = $this->actingAs($medecinUser)->post(route('ordonnance.store', $consultation->id), $ordonnanceData);

        $response->assertStatus(302); 
        
        $this->assertDatabaseHas('ordonnances', [
            'consultation_id' => $consultation->id,
        ]);

        $ordonnance = Ordonnance::where('consultation_id', $consultation->id)->first();

        $this->assertDatabaseHas('ordonnance_lignes', [
            'ordonnance_id' => $ordonnance->id,
            'medicament' => 'Doliprane',
            'dose' => '1000mg',
        ]);

    }

    public function test_medecin_can_export_ordonnance_pdf()
    {
        $medecinUser = User::factory()->create(['role' => 'medecin']);
        $consultation = $this->createConsultation();
        
        $ordonnance = Ordonnance::create([
            'consultation_id' => $consultation->id,
            'reference' => 'ORD-' . date('YmdHis'),
            'date_ordonnance' => now()->toDateString(),
        ]);
        
        OrdonnanceLigne::create([
            'ordonnance_id' => $ordonnance->id,
            'medicament' => 'Doliprane',
            'dose' => '1000mg',
            'posologie' => '1/j',
            'duree' => '3 jours',
        ]);

        $response = $this->actingAs($medecinUser)->get(route('ordonnance.telecharger', $ordonnance->id));

        $response->assertStatus(200);
        
    }
}
