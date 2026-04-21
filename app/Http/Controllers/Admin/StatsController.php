<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Medecin;
use App\Models\RendezVous;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    /**
     * Point d'entrée principal du tableau de bord.
     * Récupère l'ensemble des données analytiques pour la vue.
     */
    public function index()
    {
        return view('admin.stats', [
            // Indicateurs clés de performance (KPIs)
            'metrics'           => $this->getIndicateursPerformance(),
            
            // Analyse de la population des patients
            'demographie'       => $this->getDemographiePatients(),
            
            // Évolution des rendez-vous sur les 6 derniers mois
            'tendancesMois'     => $this->getTendancesMensuelles(),
            
            // Répartition des consultations par domaine médical
            'statsSpecialites'  => $this->getConsultationsParSpecialite(),
            
            // Analyse des périodes de forte affluence (Heatmap)
            'picsAffluence'     => $this->getHeuresDePointeHebdo(),
        ]);
    }

    /**
     * Calcule les indicateurs globaux (Croissance, Rétention, Attente).
     */
    private function getIndicateursPerformance()
    {
        // Temps moyen d'attente entre la prise de RDV et la consultation
        $attenteMoyenne = RendezVous::select(DB::raw('AVG(DATEDIFF(date_heure, created_at)) as moyenne'))
            ->where('statut', '!=', 'annulé')
            ->first()->moyenne ?? 0;

        // Calcul de la croissance des nouveaux patients (Mois en cours vs Mois précédent)
        $moisActuel = Patient::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $moisPrecedent = Patient::whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year)->count();
        $croissance = ($moisPrecedent > 0) ? (($moisActuel - $moisPrecedent) / $moisPrecedent) * 100 : ($moisActuel > 0 ? 100 : 0);

        // Taux de rétention (Patients ayant effectué plus d'une visite)
        $totalPatients = Patient::count();
        $patientsFideles = Patient::has('rendezVous', '>', 1)->count();
        $tauxRetention = ($totalPatients > 0) ? ($patientsFideles / $totalPatients) * 100 : 0;

        $presents = RendezVous::where('statut', 'termine')->count();
        $absents = RendezVous::where('statut', 'annule')->count(); // Ou un autre statut 'absent' si tu l'as
        $totalRDV = $presents + $absents;
        $tauxPresence = ($totalRDV > 0) ? ($presents / $totalRDV) * 100 : 0;

        // RDV ce mois vs mois précédent
        $rdvMoisActuel = RendezVous::whereMonth('date_heure', now()->month)
            ->whereYear('date_heure', now()->year)
            ->count();

        $rdvMoisPrecedent = RendezVous::whereMonth('date_heure', now()->subMonth()->month)
            ->whereYear('date_heure', now()->subMonth()->year)
            ->count();

        $croissanceRDV = ($rdvMoisPrecedent > 0)
            ? (($rdvMoisActuel - $rdvMoisPrecedent) / $rdvMoisPrecedent) * 100
            : ($rdvMoisActuel > 0 ? 100 : 0);

        return [
            'attente_moyenne' => round($attenteMoyenne, 1),
            'total_patients'  => $totalPatients,
            'croissance'      => round($croissance, 1),
            'total_rdv'       => RendezVous::count(),
            'croissance_rdv' => round($croissanceRDV, 1),
            'taux_retention'  => round($tauxRetention, 1),
            'taux_presence'   => round($tauxPresence, 1),
            'presents'        => $presents,
            'absents'         => $absents,
        ];
    }

    /**
     * Analyse démographique par tranche d'âge et par genre.
     */
    private function getDemographiePatients()
{
    $ageCase = "CASE 
        WHEN TIMESTAMPDIFF(YEAR, date_naissance, CURDATE()) BETWEEN 0 AND 12 THEN '1. Enfants (0-12)'
        WHEN TIMESTAMPDIFF(YEAR, date_naissance, CURDATE()) BETWEEN 13 AND 17 THEN '2. Adolescents (13-17)'
        WHEN TIMESTAMPDIFF(YEAR, date_naissance, CURDATE()) BETWEEN 18 AND 35 THEN '3. Jeunes Adultes (18-35)'
        WHEN TIMESTAMPDIFF(YEAR, date_naissance, CURDATE()) BETWEEN 36 AND 50 THEN '4. Adultes (36-50)'
        WHEN TIMESTAMPDIFF(YEAR, date_naissance, CURDATE()) BETWEEN 51 AND 65 THEN '5. Séniors (51-65)'
        ELSE '6. Âge d\'or (65+)'
    END";

    return Patient::select(
            DB::raw("$ageCase as segment_age"),
            'genre',
            DB::raw('count(*) as total')
        )
        ->groupBy(DB::raw($ageCase), 'genre')
        ->orderBy('segment_age')
        ->get();
}
    /**
     * Récupère le volume de rendez-vous mensuel pour l'analyse des tendances.
     */
    private function getTendancesMensuelles()
{
    return RendezVous::select(
            DB::raw("DATE(date_heure) as date"), 
            DB::raw("COUNT(*) as total_rdv")
        )
        ->whereBetween('date_heure', [
            now()->subDays(7)->startOfDay(),
            now()->addDays(7)->endOfDay()
        ])
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();
}

    /**
     * Calcule la répartition des consultations selon les spécialités médicales.
     */
    private function getConsultationsParSpecialite()
    {
        return RendezVous::join('medecins', 'rendez_vous.medecin_id', '=', 'medecins.id')
            ->select('medecins.specialite', DB::raw('count(*) as total'))
            ->groupBy('medecins.specialite')
            ->orderByDesc('total')
            ->get();
    }

    /**
     * Identifie les jours et heures de forte activité (Heatmap).
     */
   private function getHeuresDePointeHebdo()
    {
        return RendezVous::select(

                DB::raw("CASE DAYOFWEEK(date_heure) 
                    WHEN 2 THEN 'Lun' 
                    WHEN 3 THEN 'Mar' 
                    WHEN 4 THEN 'Mer' 
                    WHEN 5 THEN 'Jeu' 
                    WHEN 6 THEN 'Ven' 
                    WHEN 7 THEN 'Sam' 
                    WHEN 1 THEN 'Dim' 
                END as jour"),
                DB::raw("HOUR(date_heure) as heure"),
                DB::raw("count(*) as total")
            )
            ->groupBy('jour', 'heure', DB::raw("DAYOFWEEK(date_heure)"))
            ->orderBy(DB::raw("DAYOFWEEK(date_heure)")) 
            ->get();
    }
}