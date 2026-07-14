<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pole;
use App\Models\Utilisateur;

class PoleController extends Controller
{
    
    public function index()
    {
    $poles = Pole::all();
    $managers = Utilisateur::all();
    return view('poles.index', compact('poles', 'managers'));
    }

    public function create()
    {
    $managers = Utilisateur::all();
    return view('poles.create', compact('managers'));
    }

   public function store(Request $request)
    {
    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'description' => 'nullable|string',
        'manager_id' => 'required|exists:utilisateurs,utilisateur_id',
    ]);

    Pole::create($validated);

    return redirect()->route('poles.index');
    }

    public function show(string $id)
    {
    $pole = Pole::findOrFail($id);
    return view('poles.show', compact('pole'));
    }

    public function edit(string $id)
    {
    $pole = Pole::findOrFail($id);
    $managers = Utilisateur::all();
    return view('poles.edit', compact('pole', 'managers'));
    }

    public function update(Request $request, string $id)
    {
    $pole = Pole::findOrFail($id);

    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'description' => 'nullable|string',
        'manager_id' => 'required|exists:utilisateurs,utilisateur_id',
    ]);

    $pole->update($validated);

    return redirect()->route('poles.index');
    }

    public function destroy(string $id)
    {
    $pole = Pole::findOrFail($id);
    $pole->delete();

    return redirect()->route('poles.index');
    }
}
