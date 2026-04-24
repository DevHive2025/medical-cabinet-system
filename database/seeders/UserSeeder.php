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
        // 8 Médecins
        $medecinsData = [
            ['nom' => 'Alami',    'prenom' => 'Dr. Yassine', 'email' => 'y.alami@gmail.com',    'specialite' => 'Cardiologie',       'tel' => '0661998877'],
            ['nom' => 'Berrada',  'prenom' => 'Dr. Leila',   'email' => 'l.berrada@gmail.com',  'specialite' => 'Médecine Générale', 'tel' => '0661887766'],
            ['nom' => 'Tahiri',   'prenom' => 'Dr. Karim',   'email' => 'k.tahiri@gmail.com',   'specialite' => 'Médecine Générale', 'tel' => '0662334455'],
            ['nom' => 'Mansouri', 'prenom' => 'Dr. Nadia',   'email' => 'n.mansouri@gmail.com', 'specialite' => 'Dermatologie',      'tel' => '0663445566'],
            ['nom' => 'Filali',   'prenom' => 'Dr. Hassan',  'email' => 'h.filali@gmail.com',   'specialite' => 'Cardiologie',       'tel' => '0664556677'],
            ['nom' => 'Benali',   'prenom' => 'Dr. Sara',    'email' => 's.benali@gmail.com',   'specialite' => 'Gynécologie',       'tel' => '0665667788'],
            ['nom' => 'Kettani',  'prenom' => 'Dr. Omar',    'email' => 'o.kettani@gmail.com',  'specialite' => 'Dermatologie',      'tel' => '0666778899'],
            ['nom' => 'Rahimi',   'prenom' => 'Dr. Zineb',   'email' => 'z.rahimi@gmail.com',   'specialite' => 'Médecine Générale', 'tel' => '0667889900'],
        ];
        foreach ($medecinsData as $data) {
            $u = User::create([
                'nom' => $data['nom'], 'prenom' => $data['prenom'],
                'email' => $data['email'], 'password' => Hash::make('password'), 'role' => 'medecin'
            ]);
            $u->medecin()->create(['specialite' => $data['specialite'], 'cabinet_telephone' => $data['tel']]);
        }

        // 4 Secrétaires
        $secretairesData = [
            ['nom' => 'Idrissi',   'prenom' => 'Fatima',  'email' => 'f.idrissi@gmail.com',   'bureau' => 'Accueil - A1'],
            ['nom' => 'Chraibi',   'prenom' => 'Samira',  'email' => 's.chraibi@gmail.com',   'bureau' => 'Accueil - A2'],
            ['nom' => 'Lahlou',    'prenom' => 'Houda',   'email' => 'h.lahlou@gmail.com',    'bureau' => 'Secrétariat - B1'],
            ['nom' => 'Moussaoui', 'prenom' => 'Nadia',   'email' => 'n.moussaoui@gmail.com', 'bureau' => 'Secrétariat - B2'],
        ];
        foreach ($secretairesData as $data) {
            $u = User::create([
                'nom' => $data['nom'], 'prenom' => $data['prenom'],
                'email' => $data['email'], 'password' => Hash::make('password'), 'role' => 'secretaire'
            ]);
            $u->secretaire()->create(['bureau' => $data['bureau']]);
        }

        // 15 Patients
        $patientsData = [
            ['nom' => 'Amrani',  'prenom' => 'Omar',    'email' => 'o.amrani@gmail.com',   'cin' => 'EE123456', 'date_naissance' => '1985-06-15', 'genre' => 'homme', 'tel' => '0661223344', 'gs' => 'O+',  'allergies' => 'Pénicilline',          'maladies' => 'Aucune'],
            ['nom' => 'Bennani', 'prenom' => 'Khadija', 'email' => 'k.bennani@gmail.com',  'cin' => 'JK889900', 'date_naissance' => '1999-06-15', 'genre' => 'femme', 'tel' => '0661556677', 'gs' => 'A-',  'allergies' => 'Aucune',               'maladies' => 'Diabète Type 2'],
            ['nom' => 'Zouhair', 'prenom' => 'Mohamed', 'email' => 'm.zouhair@gmail.com',  'cin' => 'CD445566', 'date_naissance' => '2004-06-15', 'genre' => 'homme', 'tel' => '0661889900', 'gs' => 'B+',  'allergies' => 'Aucune',               'maladies' => 'Aucune'],
            ['nom' => 'Chami',   'prenom' => 'Sanaa',   'email' => 's.chami@gmail.com',    'cin' => 'AE112233', 'date_naissance' => '1990-06-15', 'genre' => 'femme', 'tel' => '0661001122', 'gs' => 'AB+', 'allergies' => 'Aspirine',             'maladies' => 'Hypertension'],
            ['nom' => 'Ouali',   'prenom' => 'Rachid',  'email' => 'r.ouali@gmail.com',    'cin' => 'BK334455', 'date_naissance' => '1978-03-22', 'genre' => 'homme', 'tel' => '0662112233', 'gs' => 'O-',  'allergies' => 'Aucune',               'maladies' => 'Asthme'],
            ['nom' => 'Tazi',    'prenom' => 'Imane',   'email' => 'i.tazi@gmail.com',     'cin' => 'GH556677', 'date_naissance' => '1995-11-08', 'genre' => 'femme', 'tel' => '0663223344', 'gs' => 'A+',  'allergies' => 'Latex',                'maladies' => 'Aucune'],
            ['nom' => 'Bakkali', 'prenom' => 'Youssef', 'email' => 'y.bakkali@gmail.com',  'cin' => 'LM778899', 'date_naissance' => '1968-09-30', 'genre' => 'homme', 'tel' => '0664334455', 'gs' => 'B-',  'allergies' => 'Aucune',               'maladies' => 'Diabète Type 1'],
            ['nom' => 'Hajji',   'prenom' => 'Loubna',  'email' => 'l.hajji@gmail.com',    'cin' => 'NP990011', 'date_naissance' => '2001-01-17', 'genre' => 'femme', 'tel' => '0665445566', 'gs' => 'AB-', 'allergies' => 'Aucune',               'maladies' => 'Aucune'],
            ['nom' => 'Karimi',  'prenom' => 'Amine',   'email' => 'a.karimi@gmail.com',   'cin' => 'QR112233', 'date_naissance' => '1972-04-10', 'genre' => 'homme', 'tel' => '0666112233', 'gs' => 'O+',  'allergies' => 'Sulfamides',           'maladies' => 'Insuffisance rénale'],
            ['nom' => 'Saidi',   'prenom' => 'Nour',    'email' => 'n.saidi@gmail.com',    'cin' => 'ST334455', 'date_naissance' => '2000-08-25', 'genre' => 'femme', 'tel' => '0667223344', 'gs' => 'A+',  'allergies' => 'Aucune',               'maladies' => 'Aucune'],
            ['nom' => 'Berkouk', 'prenom' => 'Khalid',  'email' => 'k.berkouk@gmail.com',  'cin' => 'UV556677', 'date_naissance' => '1960-12-03', 'genre' => 'homme', 'tel' => '0668334455', 'gs' => 'B+',  'allergies' => 'Iode',                 'maladies' => 'Diabète Type 2, Hypertension'],
            ['nom' => 'Fassi',   'prenom' => 'Meriem',  'email' => 'm.fassi@gmail.com',    'cin' => 'WX778899', 'date_naissance' => '1988-07-19', 'genre' => 'femme', 'tel' => '0669445566', 'gs' => 'O-',  'allergies' => 'Aucune',               'maladies' => 'Aucune'],
            ['nom' => 'Naciri',  'prenom' => 'Hamza',   'email' => 'h.naciri@gmail.com',   'cin' => 'YZ990011', 'date_naissance' => '1993-02-14', 'genre' => 'homme', 'tel' => '0660556677', 'gs' => 'AB+', 'allergies' => 'Pénicilline, Aspirine', 'maladies' => 'Aucune'],
            ['nom' => 'Ziani',   'prenom' => 'Hajar',   'email' => 'h.ziani@gmail.com',    'cin' => 'AB223344', 'date_naissance' => '1997-05-30', 'genre' => 'femme', 'tel' => '0661667788', 'gs' => 'A-',  'allergies' => 'Aucune',               'maladies' => 'Asthme'],
            ['nom' => 'Moukrim', 'prenom' => 'Tariq',   'email' => 't.moukrim@gmail.com',  'cin' => 'CD445577', 'date_naissance' => '1975-10-08', 'genre' => 'homme', 'tel' => '0662778899', 'gs' => 'B-',  'allergies' => 'Aucune',               'maladies' => 'Cholestérol'],
        ];
        foreach ($patientsData as $data) {
            $u = User::create([
                'nom' => $data['nom'], 'prenom' => $data['prenom'],
                'email' => $data['email'], 'password' => Hash::make('password'), 'role' => 'patient'
            ]);
            $p = $u->patient()->create([
                'cin' => $data['cin'], 'date_naissance' => $data['date_naissance'],
                'telephone' => $data['tel'], 'genre' => $data['genre']
            ]);
            $p->dossierMedical()->create([
                'groupe_sanguin'      => $data['gs'],
                'allergies'           => $data['allergies'],
                'maladies_chroniques' => $data['maladies'],
            ]);
        }
    }
}
