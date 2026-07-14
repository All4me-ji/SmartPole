@extends('layouts.app')

    @section('title', 'Ajouter un objectif - SmartPole')

@section('content')
    <h1>Ajouter un objectif</h1>

    <form method="POST" action="{{ route('objectifs.store') }}">
        @csrf

        <label for="cible">Cible :</label><br>
        <input type="number" step="0.01" name="cible" id="cible"><br><br>

        <label for="periode">Période :</label><br>
        <input type="text" name="periode" id="periode" placeholder="ex: Janvier 2026"><br><br>

        <label for="pole_id">Pôle :</label><br>
        <select name="pole_id" id="pole_id">
            @foreach ($poles as $pole)
                <option value="{{ $pole->pole_id }}">{{ $pole->nom }}</option>
            @endforeach
        </select><br><br>

        <button type="submit">Enregistrer</button>
    </form>

    <a href="{{ route('objectifs.index') }}">Retour à la liste</a>
@endsection