<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Medecin;
use App\Models\Patient;
use App\Models\Secretaire;
use App\Models\DossierMedical;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
    // 2 Medecins (Cardiologue et Généraliste)
        $med1 = User::create([
            'nom' => 'Alami', 'prenom' => 'Dr. Yassine',
            'email' => 'y.alami@gmail.com', 'password' => Hash::make('password123'), 'role' => 'medecin'
        ]);
        $med1->medecin()->create(['specialite' => 'Cardiologie', 'cabinet_telephone' => '0661998877']);

        $med2 = User::create([
            'nom' => 'Berrada', 'prenom' => 'Dr. Leila',
            'email' => 'l.berrada@gmail.com', 'password' => Hash::make('password123'), 'role' => 'medecin'
        ]);
        $med2->medecin()->create(['specialite' => 'Médecine Générale', 'cabinet_telephone' => '0661887766']);

        // 2 Secretaires
        $sec1 = User::create([
            'nom' => 'Idrissi', 'prenom' => 'Fatima',
            'email' => 'f.idrissi@gmail.com', 'password' => Hash::make('password123'), 'role' => 'secretaire'
        ]);
        $sec1->secretaire()->create(['bureau' => 'Accueil - A1']);

        // 4 Patients avec des données réelles
        $patientsData = [
            ['nom' => 'Amrani', 'prenom' => 'Omar', 'email' => 'o.amrani@gmail.com', 'cin' => 'EE123456', 'tel' => '0661223344', 'gs' => 'O+'],
            ['nom' => 'Bennani', 'prenom' => 'Khadija', 'email' => 'k.bennani@gmail.com', 'cin' => 'JK889900', 'tel' => '0661556677', 'gs' => 'A-'],
            ['nom' => 'Zouhair', 'prenom' => 'Mohamed', 'email' => 'm.zouhair@gmail.com', 'cin' => 'CD445566', 'tel' => '0661889900', 'gs' => 'B+'],
            ['nom' => 'Chami', 'prenom' => 'Sanaa', 'email' => 's.chami@gmail.com', 'cin' => 'AE112233', 'tel' => '0661001122', 'gs' => 'AB+'],
        ];

        foreach ($patientsData as $data) {
            $u = User::create([
                'nom' => $data['nom'], 'prenom' => $data['prenom'],
                'email' => $data['email'], 'password' => bcrypt('password'), 'role' => 'patient'
            ]);
            $p = $u->patient()->create([
                'cin' => $data['cin'], 'date_naissance' => '1985-06-15', 'telephone' => $data['tel']
            ]);
            $p->dossierMedical()->create([
                'groupe_sanguin' => $data['gs'],
                'allergies' => ($data['prenom'] == 'Omar') ? 'Pénicilline' : 'Aucune',
                'maladies_chroniques' => ($data['prenom'] == 'Khadija') ? 'Diabète Type 2' : 'Aucune'
            ]);
        }

    }
}