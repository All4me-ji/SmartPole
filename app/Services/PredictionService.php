<?php
namespace App\Services;

class PredictionService
{
    private function calculerCoefficients(array $x, array $y): ?array
    {
        $n = count($x);

        if ($n < 2) {
            return null;
        }

        $sommeX = array_sum($x);
        $sommeY = array_sum($y);
        $sommeXY = 0;
        $sommeX2 = 0;

        for ($i = 0; $i < $n; $i++) {
            $sommeXY += $x[$i] * $y[$i];
            $sommeX2 += $x[$i] * $x[$i];
        }

        $denominateur = ($n * $sommeX2) - ($sommeX * $sommeX);

        if ($denominateur == 0) {
            return null;
        }

        $a = (($n * $sommeXY) - ($sommeX * $sommeY)) / $denominateur;
        $b = ($sommeY - ($a * $sommeX)) / $n;

        return ['a' => $a, 'b' => $b];
    }

    public function regressionLineaire(array $x, array $y, int $nombreAPredire = 3): array
    {
        $n = count($x);
        $coef = $this->calculerCoefficients($x, $y);

        if ($coef === null) {
            $valeurDefaut = $n > 0 ? end($y) : 0;
            return array_fill(0, $nombreAPredire, $valeurDefaut);
        }

        $a = $coef['a'];
        $b = $coef['b'];

        $predictions = [];
        $dernierX = end($x);

        for ($i = 1; $i <= $nombreAPredire; $i++) {
            $xFutur = $dernierX + $i;
            $yPredit = ($a * $xFutur) + $b;
            $predictions[] = round(max($yPredit, 0), 2); 
        }

        return $predictions;
    }

    public function expliquerTendance(array $x, array $y): string
    {
        $coef = $this->calculerCoefficients($x, $y);

        if ($coef === null) {
            return "Pas assez de données pour dégager une tendance claire.";
        }

        $pente = round($coef['a'], 2);

        if (abs($pente) < 1) {
            return "Les ventes de ce pôle restent globalement stables d'un mois à l'autre.";
        }

        if ($pente > 0) {
            return "Les ventes de ce pôle suivent une tendance à la hausse, avec une progression moyenne d'environ "
                . number_format($pente, 0, ',', ' ') . " dh par mois.";
        }

        return "Les ventes de ce pôle suivent une tendance à la baisse, avec une diminution moyenne d'environ "
            . number_format(abs($pente), 0, ',', ' ') . " dh par mois.";
    }

    public function evaluerModele(array $x, array $y): ?array
{
    $n = count($x);
    $coef = $this->calculerCoefficients($x, $y);

    if ($coef === null || $n < 2) {
        return null;
    }

    $a = $coef['a'];
    $b = $coef['b'];

    $moyenneY = array_sum($y) / $n;

    $sommeCarresTotale = 0;      
    $sommeCarresResidus = 0;     
    $sommeErreursAbsolues = 0;   

    for ($i = 0; $i < $n; $i++) {
        $yPredit = ($a * $x[$i]) + $b;
        $erreur = $y[$i] - $yPredit;

        $sommeCarresResidus += $erreur ** 2;
        $sommeCarresTotale += ($y[$i] - $moyenneY) ** 2;
        $sommeErreursAbsolues += abs($erreur);
    }

    $r2 = $sommeCarresTotale != 0
        ? 1 - ($sommeCarresResidus / $sommeCarresTotale)
        : null;

    $mae = $sommeErreursAbsolues / $n;

    $rmse = sqrt($sommeCarresResidus / $n);

    return [
        'r2'   => $r2 !== null ? round($r2, 3) : null,
        'mae'  => round($mae, 2),
        'rmse' => round($rmse, 2),
    ];
}

}