<?php
namespace App\Http\Controllers;

use App\Models\Vente;
use App\Models\Pole;
use Illuminate\Http\Request;

class VenteController extends Controller
{
    public function index(Request $request)
{
    $query = Vente::with('pole');

    // Filtre par pôle
    if ($request->filled('pole_id')) {
        $query->where('pole_id', $request->pole_id);
    }

    // Filtre par période
    if ($request->filled('date_debut')) {
        $query->where('date', '>=', $request->date_debut);
    }
    if ($request->filled('date_fin')) {
        $query->where('date', '<=', $request->date_fin);
    }

    // Recherche par montant
    if ($request->filled('montant_min')) {
        $query->where('montant', '>=', $request->montant_min);
    }

    $ventes = $query->orderBy('date', 'desc')->get();
    $poles = \App\Models\Pole::all();

    return view('ventes.index', compact('ventes', 'poles'));
}

    public function create()
    {
        $poles = Pole::all();
        return view('ventes.create', compact('poles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'montant' => 'required|numeric',
            'cout' => 'required|numeric',
            'benefice' => 'required|numeric',
            'pole_id' => 'required|exists:poles,pole_id',
        ]);

        Vente::create($validated);

        return redirect()->route('ventes.index');
    }

    public function show(string $id)
    {
        $vente = Vente::findOrFail($id);
        return view('ventes.show', compact('vente'));
    }

    public function edit(string $id)
    {
        $vente = Vente::findOrFail($id);
        $poles = Pole::all();
        return view('ventes.edit', compact('vente', 'poles'));
    }

    public function update(Request $request, string $id)
    {
        $vente = Vente::findOrFail($id);

        $validated = $request->validate([
            'date' => 'required|date',
            'montant' => 'required|numeric',
            'cout' => 'required|numeric',
            'benefice' => 'required|numeric',
            'pole_id' => 'required|exists:poles,pole_id',
        ]);

        $vente->update($validated);

        return redirect()->route('ventes.index');
    }

    public function destroy(string $id)
    {
        $vente = Vente::findOrFail($id);
        $vente->delete();

        return redirect()->route('ventes.index');
    }
}