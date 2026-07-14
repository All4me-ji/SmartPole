<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;

class UtilisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
    $utilisateurs = Utilisateur::all();
    return view('utilisateurs.index', compact('utilisateurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return view('utilisateurs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'email' => 'required|email|unique:utilisateurs,email',
        'mot_de_passe' => 'required|string|min:6',
        'role' => 'required|string|max:255',
    ]);

    $validated['mot_de_passe'] = bcrypt($validated['mot_de_passe']);

    Utilisateur::create($validated);

    return redirect()->route('utilisateurs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    $utilisateur = Utilisateur::findOrFail($id);
    return view('utilisateurs.show', compact('utilisateur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $utilisateur = Utilisateur::findOrFail($id);
    return view('utilisateurs.edit', compact('utilisateur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    $utilisateur = Utilisateur::findOrFail($id);

    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'email' => 'required|email|unique:utilisateurs,email,' . $id . ',utilisateur_id',
        'mot_de_passe' => 'nullable|string|min:6',
        'role' => 'required|string|max:255',
    ]);

    if (!empty($validated['mot_de_passe'])) {
        $validated['mot_de_passe'] = bcrypt($validated['mot_de_passe']);
    } else {
        unset($validated['mot_de_passe']);
    }

    $utilisateur->update($validated);

    return redirect()->route('utilisateurs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        $utilisateur->delete();
        return redirect()->route('utilisateurs.index');
    }

    public function desactiver(string $id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        $utilisateur->statut = false;
        $utilisateur->save();
        return redirect()->route('utilisateurs.index');
    }

    public function reactiver(string $id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        $utilisateur->statut = true;
        $utilisateur->save();
        return redirect()->route('utilisateurs.index');
    }

public function profil()
{
    $utilisateur = auth()->user();
    return view('utilisateurs.profil', compact('utilisateur'));
}

public function updateProfil(Request $request)
{
    $utilisateur = auth()->user();

    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'mot_de_passe' => 'nullable|string|min:6',
    ]);

    if (!empty($validated['mot_de_passe'])) {
        $validated['mot_de_passe'] = bcrypt($validated['mot_de_passe']);
    } else {
        unset($validated['mot_de_passe']);
    }

    $utilisateur->update($validated);

    return redirect()->route('profil')->with('success', 'Profil mis a jour avec succes.');
}
}
