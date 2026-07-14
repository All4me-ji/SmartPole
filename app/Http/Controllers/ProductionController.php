<?php
namespace App\Http\Controllers;

use App\Models\Production;
use App\Models\Pole;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function index()
    {
        $productions = Production::all();
        $poles = Pole::all();
        return view('production.index', compact('productions', 'poles'));
    }

    public function create()
    {
        $poles = Pole::all();
        return view('production.create', compact('poles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'produit' => 'required|string|max:255',
            'quantite' => 'required|integer',
            'pole_id' => 'required|exists:poles,pole_id',
        ]);

        Production::create($validated);

        return redirect()->route('production.index');
    }

    public function show(string $id)
    {
        $production = Production::findOrFail($id);
        return view('production.show', compact('production'));
    }

    public function edit(string $id)
    {
        $production = Production::findOrFail($id);
        $poles = Pole::all();
        return view('production.edit', compact('production', 'poles'));
    }

    public function update(Request $request, string $id)
    {
        $production = Production::findOrFail($id);

        $validated = $request->validate([
            'date' => 'required|date',
            'produit' => 'required|string|max:255',
            'quantite' => 'required|integer',
            'pole_id' => 'required|exists:poles,pole_id',
        ]);

        $production->update($validated);

        return redirect()->route('production.index');
    }

    public function destroy(string $id)
    {
        $production = Production::findOrFail($id);
        $production->delete();

        return redirect()->route('production.index');
    }
}