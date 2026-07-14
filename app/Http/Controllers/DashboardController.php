<?php
namespace App\Http\Controllers;

use App\Models\Pole;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index()
{
    $poles = Pole::with(['ventes', 'productions', 'objectifs'])->get();

    $labels = [];
    $totalVentes = [];
    $totalCouts = [];
    $totalBenefices = [];
    $totalProduction = [];
    $totalObjectifs = [];
    $margesBrutes = [];
    $tauxAtteinte = [];
    $tauxAtteinteProduction = [];
    $nombreVentes = [];
    $typesPoles = [];

    foreach ($poles as $pole) {
        $labels[] = $pole->nom;
        $ventes = $pole->ventes->sum('montant');
        $couts = $pole->ventes->sum('cout');
        $benefices = $pole->ventes->sum('benefice');
        $cible = $pole->objectifs->sum('cible');
        $quantiteProduite = $pole->productions->sum('quantite');

        $totalVentes[] = $ventes;
        $nombreVentes[] = $pole->ventes->count();
        $totalCouts[] = $couts;
        $totalBenefices[] = $benefices;
        $totalProduction[] = $quantiteProduite;
        $totalObjectifs[] = $cible;

        $margesBrutes[] = $ventes > 0
            ? round(($benefices / $ventes) * 100, 1)
            : 0;

        $tauxAtteinte[] = $cible > 0
            ? round(($ventes / $cible) * 100, 1)
            : 0;

        $tauxAtteinteProduction[] = $cible > 0
            ? round(($quantiteProduite / $cible) * 100, 1)
            : 0;

        // Classification du pôle selon son activité réelle
        if ($pole->ventes->count() > 0) {
            $typesPoles[] = 'commercial';
        } elseif ($pole->productions->count() > 0) {
            $typesPoles[] = 'production';
        } else {
            $typesPoles[] = 'autre';
        }
    }

    $couleurMarges = array_map(function($m) {
        if ($m >= 20) return 'rgba(75, 192, 92, 0.6)';
        if ($m >= 10) return 'rgba(255, 159, 64, 0.6)';
        return 'rgba(255, 99, 132, 0.6)';
    }, $margesBrutes);

    $alertes = [];
    foreach ($poles as $index => $pole) {
        if ($margesBrutes[$index] > 0 && $margesBrutes[$index] < 10) {
            $alertes[] = [
                'type' => 'danger',
                'message' => "Marge insuffisante pour le pole {$pole->nom} : {$margesBrutes[$index]}%"
            ];
        }
        if ($tauxAtteinte[$index] > 0 && $tauxAtteinte[$index] < 75) {
            $alertes[] = [
                'type' => 'warning',
                'message' => "Objectif non atteint pour le pole {$pole->nom} : {$tauxAtteinte[$index]}% de l objectif realise"
            ];
        }
        if ($totalVentes[$index] == 0) {
            $alertes[] = [
                'type' => 'info',
                'message' => "Aucune vente enregistree pour le pole {$pole->nom}"
            ];
        }
    }

    // Évolution mensuelle des ventes (toutes pôles confondus)
    $evolutionMensuelle = \App\Models\Vente::selectRaw("TO_CHAR(date, 'YYYY-MM') as mois, SUM(montant) as total")
        ->groupBy('mois')
        ->orderBy('mois')
        ->get();

    $moisLabels = $evolutionMensuelle->pluck('mois');
    $moisTotaux = $evolutionMensuelle->pluck('total');

    // Marges globales (toutes pôles confondus)
    $totalVentesGlobal = array_sum($totalVentes);
    $totalCoutsGlobal = array_sum($totalCouts);
    $totalBeneficesGlobal = array_sum($totalBenefices);
    $margeGlobale = $totalVentesGlobal > 0
        ? round(($totalBeneficesGlobal / $totalVentesGlobal) * 100, 1)
        : 0;

    // Taux de croissance (mois en cours vs mois précédent)
    $moisActuel = now()->format('Y-m');
    $moisPrecedent = now()->subMonth()->format('Y-m');

    $ventesMoisActuel = \App\Models\Vente::whereRaw("TO_CHAR(date, 'YYYY-MM') = ?", [$moisActuel])->sum('montant');
    $ventesMoisPrecedent = \App\Models\Vente::whereRaw("TO_CHAR(date, 'YYYY-MM') = ?", [$moisPrecedent])->sum('montant');

    $tauxCroissance = $ventesMoisPrecedent > 0
        ? round((($ventesMoisActuel - $ventesMoisPrecedent) / $ventesMoisPrecedent) * 100, 1)
        : null;

    return view('dashboard.index', compact(
        'labels',
        'totalVentes',
        'totalCouts',
        'totalBenefices',
        'totalProduction',
        'totalObjectifs',
        'margesBrutes',
        'couleurMarges',
        'tauxAtteinte',
        'tauxAtteinteProduction',
        'typesPoles',
        'alertes',
        'nombreVentes',
        'moisLabels',
        'moisTotaux',
        'totalVentesGlobal',
        'totalCoutsGlobal',
        'totalBeneficesGlobal',
        'margeGlobale',
        'ventesMoisActuel',
        'ventesMoisPrecedent',
        'tauxCroissance'
    ));
}
}