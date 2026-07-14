@extends('layouts.app')

    @section('title', $utilisateur->nom . ' - SmartPole')

@section('content')
    <h1>{{ $utilisateur->nom }}</h1>

    <p><strong>Email :</strong> {{ $utilisateur->email }}</p>
    <p><strong>Rôle :</strong> {{ $utilisateur->role }}</p>

    <h2>Pôles gérés</h2>
    @if ($utilisateur->poles->isEmpty())
        <p>Aucun pôle géré.</p>
    @else
        <ul>
            @foreach ($utilisateur->poles as $pole)
                <li>{{ $pole->nom }}</li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('utilisateurs.edit', $utilisateur->utilisateur_id) }}">Modifier</a>
    |
    <a href="{{ route('utilisateurs.index') }}">Retour à la liste</a>
@endsection