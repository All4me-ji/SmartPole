@extends('layouts.app')

    @section('title', 'Modifier ' . $utilisateur->nom . ' - SmartPole')

@section('content')
    <h1>Modifier l'utilisateur</h1>

    <form method="POST" action="{{ route('utilisateurs.update', $utilisateur->utilisateur_id) }}">
        @csrf
        @method('PUT')

        <label for="nom">Nom :</label><br>
        <input type="text" name="nom" id="nom" value="{{ $utilisateur->nom }}"><br><br>

        <label for="email">Email :</label><br>
        <input type="email" name="email" id="email" value="{{ $utilisateur->email }}"><br><br>

        <label for="mot_de_passe">Nouveau mot de passe (laisser vide pour ne pas changer) :</label><br>
        <input type="password" name="mot_de_passe" id="mot_de_passe"><br><br>

        <label for="role">Rôle :</label><br>
        <select name="role" id="role">
            <option value="administrateur" @if($utilisateur->role == 'administrateur') selected @endif>Administrateur</option>
            <option value="responsable" @if($utilisateur->role == 'responsable') selected @endif>Responsable de pôle</option>
            <option value="direction" @if($utilisateur->role == 'direction') selected @endif>Direction</option>
        </select><br><br>

        <button type="submit">Mettre à jour</button>
    </form>

    <a href="{{ route('utilisateurs.index') }}">Retour à la liste</a>
@endsection