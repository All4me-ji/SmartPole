@extends('layouts.app')

    @section('title' ,'Ajouter un utilisateur - SmartPole')


@section('content')
    <h1>Ajouter un utilisateur</h1>

    <form method="POST" action="{{ route('utilisateurs.store') }}">
        @csrf

        <label for="nom">Nom :</label><br>
        <input type="text" name="nom" id="nom"><br><br>

        <label for="email">Email :</label><br>
        <input type="email" name="email" id="email"><br><br>

        <label for="mot_de_passe">Mot de passe :</label><br>
        <input type="password" name="mot_de_passe" id="mot_de_passe"><br><br>

        <label for="role">Rôle :</label><br>
        <select name="role" id="role">
            <option value="administrateur">Administrateur</option>
            <option value="responsable">Responsable de pôle</option>
            <option value="direction">Direction</option>
        </select><br><br>

        <button type="submit">Enregistrer</button>
    </form>

    <a href="{{ route('utilisateurs.index') }}">Retour à la liste</a>
@endsection