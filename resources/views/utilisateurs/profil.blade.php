@extends('layouts.app')

@section('title', 'Mon profil - SmartPole')

@section('content')
    <h1>Mon profil</h1>

    @if(session('success'))
        <div style="background-color:#d1e7dd; color:#0f5132; border:1px solid #badbcc; padding:10px; border-radius:4px; margin-bottom:1rem;">
            {{ session('success') }}
        </div>
    @endif

    <h2>Informations personnelles</h2>
    <table>
        <tbody>
            <tr>
                <td><strong>Nom</strong></td>
                <td>{{ $utilisateur->nom }}</td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td>{{ $utilisateur->email }}</td>
            </tr>
            <tr>
                <td><strong>Rôle</strong></td>
                <td>{{ ucfirst($utilisateur->role) }}</td>
            </tr>
            <tr>
                <td><strong>Statut</strong></td>
                <td>
                    @if($utilisateur->statut)
                        <span style="color:green; font-weight:bold;">Actif</span>
                    @else
                        <span style="color:red; font-weight:bold;">Désactivé</span>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <h2>Modifier mon nom ou mot de passe</h2>
    <form method="POST" action="{{ route('profil.update') }}">
        @csrf
        @method('PUT')

        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" value="{{ $utilisateur->nom }}"><br><br>

        <label for="mot_de_passe">Nouveau mot de passe :</label>
        <input type="password" name="mot_de_passe" id="mot_de_passe"><br><br>

        <button type="submit">Mettre à jour</button>
    </form>
@endsection