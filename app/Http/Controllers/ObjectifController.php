<?php
namespace App\Http\Controllers;

use App\Models\Objectif;
use App\Models\Pole;
use Illuminate\Http\Request;

class ObjectifController extends Controller
{
    public function index()
    {
        $objectifs = Objectif::all();
        $poles = Pole::all();
        return view('objectifs.index', compact('objectifs', 'poles'));
    }

    public function create()
    {
        $poles = Pole::all();
        return view('objectifs.create', compact('poles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cible' => 'required|numeric',
            'periode' => 'required|string|max:255',
            'pole_id' => 'required|exists:poles,pole_id',
        ]);

        Objectif::create($validated);

        return redirect()->route('objectifs.index');
    }

    public function show(string $id)
    {
        $objectif = Objectif::findOrFail($id);
        return view('objectifs.show', compact('objectif'));
    }

    public function edit(string $id)
    {
        $objectif = Objectif::findOrFail($id);
        $poles = Pole::all();
        return view('objectifs.edit', compact('objectif', 'poles'));
    }

    public function update(Request $request, string $id)
    {
        $objectif = Objectif::findOrFail($id);

        $validated = $request->validate([
            'cible' => 'required|numeric',
            'periode' => 'required|string|max:255',
            'pole_id' => 'required|exists:poles,pole_id',
        ]);

        $objectif->update($validated);

        return redirect()->route('objectifs.index');
    }

    public function destroy(string $id)
    {
        $objectif = Objectif::findOrFail($id);
        $objectif->delete();

        return redirect()->route('objectifs.index');
    }
}