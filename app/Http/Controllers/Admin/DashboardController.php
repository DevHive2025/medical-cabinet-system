<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\RendezVous;
use App\Models\Medecin;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. RDV Aujourd'hui
        $rdvAujourdhui = RendezVous::whereDate('date_heure', now())->count();

        // 2. Patients Last Month vs Previous Month (Calcul Percentage)
        $lastMonthCount = Patient::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
            
        $previousMonthCount = Patient::whereMonth('created_at', now()->subMonths(1)->month)
            ->whereYear('created_at', now()->subMonths(1)->year)
            ->count();

        $percentageIncrease = 0;
        if ($previousMonthCount > 0) {
            $percentageIncrease = (($lastMonthCount - $previousMonthCount) / $previousMonthCount) * 100;
        } elseif ($lastMonthCount > 0) {
            $percentageIncrease = 100;
        }

        // 3. Nbr Medecins qui travaillent aujourd'hui (Exemple: statut actif)
        $medecinsTravail = Medecin::whereHas('rendezVous', function ($query) {
            $query->whereDate('date_heure', now());
        })->count();

        // 4. Activity Logs (Tableau de log)
        $recentLogs = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // 5. Fake Data for System Status
        $systemStatus = [
            'server_load' => '24%',
            'database_status' => 'Stable',
            'storage_used' => '45.2 GB / 100 GB',
            'uptime' => '99.9%'
        ];

        return view('admin.dashboard', compact(
            'rdvAujourdhui', 
            'lastMonthCount', 
            'percentageIncrease', 
            'medecinsTravail', 
            'recentLogs',
            'systemStatus'
        ));
    }
}