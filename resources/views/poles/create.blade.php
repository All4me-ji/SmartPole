@extends('layouts.app')

@section('title', 'Ajouter un pôle - SmartPole')

@section('content')
    <h1>Ajouter un pôle</h1>

    <form method="POST" action="{{ route('poles.store') }}">
        @csrf

        <label for="nom">Nom :</label><br>
        <input type="text" name="nom" id="nom"><br><br>

        <label for="description">Description :</label><br>
        <textarea name="description" id="description"></textarea><br><br>

        <label for="manager_id">Responsable :</label><br>
        <select name="manager_id" id="manager_id">
            @foreach ($managers as $manager)
                <option value="{{ $manager->utilisateur_id }}">{{ $manager->nom }}</option>
            @endforeach
        </select><br><br>

        <button type="submit">Enregistrer</button>
    </form>

    <a href="{{ route('poles.index') }}">Retour à la liste</a>
@endsection