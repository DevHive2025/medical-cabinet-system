<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Medecin;
use App\Models\Patient;
use App\Models\Secretaire;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        $medecinUser = User::create([
            'nom' => 'Alami',
            'prenom' => 'Ahmed',
            'email' => 'medecin@test.com',
            'password' => Hash::make('password123'),
            'role' => 'medecin',
        ]);

        Medecin::create([
            'user_id' => $medecinUser->id,
            'specialite' => 'Cardiologie',
        ]);

        $patientUser = User::create([
            'nom' => 'Idrissi',
            'prenom' => 'Sara',
            'email' => 'patient@test.com',
            'password' => Hash::make('password123'),
            'role' => 'patient',
        ]);

        Patient::create([
            'user_id' => $patientUser->id,
            'cin' => 'EE123456',
            'date_naissance' => '1998-05-15',
            'telephone' => '0661223344',
        ]);

        $secretaireUser = User::create([
            'nom' => 'Tazi',
            'prenom' => 'Fatima',
            'email' => 'secretaire@test.com',
            'password' => Hash::make('password123'),
            'role' => 'secretaire',
        ]);

        Secretaire::create([
            'user_id' => $secretaireUser->id,
            'bureau' => 'Bureau A-12',
        ]);
    }
}