<?php
namespace App\Http\Controllers;

use App\Models\Pole;

class PredictionController extends Controller
{
    public function index()
    {
        $poles = Pole::all();
        return view('predictions.index', compact('poles'));
    }

    public function show(string $poleId)
    {
        $pole = Pole::findOrFail($poleId);
        $resultat = $pole->predireVentesFutures(3);

        return view('predictions.show', compact('pole', 'resultat'));
    }
}