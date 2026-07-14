<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Pole extends Model
{
    protected $primaryKey = 'pole_id';
    protected $fillable = [
        'nom',
        'description',
        'manager_id',
    ];
    public function manager()
    {
        return $this->belongsTo(Utilisateur::class, 'manager_id', 'utilisateur_id');
    }
    public function ventes()
    {
        return $this->hasMany(Vente::class, 'pole_id', 'pole_id');
    }
    public function objectifs()
    {
        return $this->hasMany(Objectif::class, 'pole_id', 'pole_id');
    }
    public function productions()
    {
        return $this->hasMany(Production::class, 'pole_id', 'pole_id');
    }
   public function predireVentesFutures(int $nombreMois = 3): array
{
    $ventesParMois = $this->ventes()
        ->selectRaw("TO_CHAR(date, 'YYYY-MM') as mois, SUM(montant) as total")
        ->groupBy('mois')
        ->orderBy('mois')
        ->get();

    if ($ventesParMois->count() < 2) {
        return [
            'historique' => $ventesParMois,
            'predictions' => [],
            'tendance' => null,
            'metriques' => null,               
            'message' => 'Pas assez de donnees historiques pour generer une prediction fiable.'
        ];
    }

    $x = range(1, $ventesParMois->count());
    $y = $ventesParMois->pluck('total')->map(fn($v) => (float) $v)->toArray();

    $service = new \App\Services\PredictionService();
    $predictions = $service->regressionLineaire($x, $y, $nombreMois);
    $tendance = $service->expliquerTendance($x, $y);
    $metriques = $service->evaluerModele($x, $y);   

    return [
        'historique' => $ventesParMois,
        'predictions' => $predictions,
        'tendance' => $tendance,
        'metriques' => $metriques,               
        'message' => null,
    ];
}
}