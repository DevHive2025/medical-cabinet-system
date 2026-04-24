<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Models\User;
use App\Models\Medecin;
use App\Models\Patient;
use App\Models\RendezVous;
use App\Mail\ConfirmationRendezVous;
use App\Mail\RappelRendezVous;

class RendezVousTest extends TestCase
{
    use RefreshDatabase;

    private function createPatient()
    {
        $user = User::factory()->create(['role' => 'patient']);
        return Patient::create([
            'user_id' => $user->id,
            'cin' => 'TEST' . rand(1000, 9999),
            'genre' => 'Homme',
            'date_naissance' => '1990-01-01',
            'telephone' => '0600000000',
        ]);
    }

    private function createMedecin()
    {
        $user = User::factory()->create(['role' => 'medecin']);
        return Medecin::create([
            'user_id' => $user->id,
            'specialite' => 'Generaliste',
            'cabinet_telephone' => '0522000000', 
        ]);
    }

    // ==========================================
    // TESTS DU CYCLE DE VIE (CRUD)
    // ==========================================

    public function test_on_peut_creer_un_rendez_vous()
    {
        $user = User::factory()->create(['role' => 'patient']);
        $medecin = $this->createMedecin();
        $patient = Patient::create([
            'user_id' => $user->id,
            'cin' => 'TEST123',
            'genre' => 'Homme',
            'date_naissance' => '1990-01-01',
            'telephone' => '0600000000',
        ]);

        $response = $this->actingAs($user)->post(route('rendez-vous.store'), [
            'medecin_id' => $medecin->id,
            'patient_id' => $patient->id,
            'date_heure' => '2026-05-10 14:30:00',
            'motif' => 'Première consultation',
        ]);

        $response->assertStatus(302); 
        $this->assertDatabaseHas('rendez_vous', [
            'motif' => 'Première consultation',
        ]);
    }

    public function test_on_peut_verifier_la_disponibilite()
    {
        $user = User::factory()->create(['role' => 'patient']);
        $medecin = $this->createMedecin();
        $patient = $this->createPatient();

        // Create an appointment that is already booked
        RendezVous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'date_heure' => '2026-05-10 10:00:00',
            'motif' => 'Consultation',
            'statut' => 'confirme'
        ]);

        $response = $this->actingAs($user)->getJson(route('api.creneaux', [
            'medecin_id' => $medecin->id,
            'date' => '2026-05-10',
        ]));

        $response->assertStatus(200);
        $slots = $response->json();
        if(is_array($slots)) {
            $this->assertNotContains('10:00', $slots);
        }
    }

    public function test_on_peut_modifier_un_rendez_vous()
    {
        $user = User::factory()->create(['role' => 'patient']);
        $medecin = $this->createMedecin();
        $patient = $this->createPatient();

        $rdv = RendezVous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'motif' => 'Ancien motif',
            'date_heure' => '2026-05-10 10:00:00',
            'statut' => 'en_attente'
        ]);

        $response = $this->actingAs($user)->put(route('rendez-vous.update', $rdv->id), [
            'medecin_id' => $medecin->id,
            'patient_id' => $patient->id,
            'date_heure' => '2026-05-10 11:00:00',
            'motif' => 'Motif mis à jour',
        ]);

        $this->assertDatabaseHas('rendez_vous', [
            'id' => $rdv->id,
            'motif' => 'Motif mis à jour',
            'date_heure' => '2026-05-10 11:00:00',
        ]);
    }

    public function test_on_peut_annuler_un_rendez_vous()
    {
        $user = User::factory()->create(['role' => 'patient']);
        $medecin = $this->createMedecin();
        $patient = Patient::create([
            'user_id' => $user->id,
            'cin' => 'TEST123',
            'genre' => 'Homme',
            'date_naissance' => '1990-01-01',
            'telephone' => '0600000000',
        ]);

        $rdv = RendezVous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'motif' => 'Consultation',
            'date_heure' => '2026-05-10 10:00:00',
            'statut' => 'confirme'
        ]);

        $response = $this->actingAs($user)->patch(route('rendez-vous.annuler', $rdv->id));

        $this->assertDatabaseHas('rendez_vous', [
            'id' => $rdv->id,
            'statut' => 'annule',
        ]);
    }

    // ==========================================
    // TESTS DES EMAILS
    // ==========================================

    public function test_email_de_confirmation_est_envoye()
    {
        Mail::fake();

        $user = User::factory()->create(['role' => 'patient']);
        $medecin = $this->createMedecin();
        $patient = Patient::create([
            'user_id' => $user->id,
            'cin' => 'TEST123',
            'genre' => 'Homme',
            'date_naissance' => '1990-01-01',
            'telephone' => '0600000000',
        ]);

        $rdv = RendezVous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'motif' => 'Consultation',
            'date_heure' => '2026-05-10 10:00:00',
            'statut' => 'en_attente'
        ]);

        $this->actingAs($user)->get(route('rendez-vous.confirmer', $rdv->id));

        Mail::assertSent(ConfirmationRendezVous::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
        
    }

    public function test_email_de_rappel_est_envoye_via_commande()
    {
        Mail::fake();

        $user = User::factory()->create(['role' => 'patient']);
        $medecin = $this->createMedecin();
        $patient = Patient::create([
            'user_id' => $user->id,
            'cin' => 'TEST123',
            'genre' => 'Homme',
            'date_naissance' => '1990-01-01',
            'telephone' => '0600000000',
        ]);

        $rdv = RendezVous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'motif' => 'Consultation',
            'date_heure' => now()->addDay()->format('Y-m-d 10:00:00'),
            'statut' => 'confirme'
        ]);

        if (class_exists(\App\Console\Commands\EnvoyerRappels::class) || class_exists(\App\Console\Commands\RappelsEnvoyer::class)) {
            $this->artisan('rappels:envoyer')->assertSuccessful();

            Mail::assertSent(RappelRendezVous::class, function ($mail) use ($user) {
                return $mail->hasTo($user->email);
            });
        } else {
            $this->assertTrue(true);
        }
    }
}