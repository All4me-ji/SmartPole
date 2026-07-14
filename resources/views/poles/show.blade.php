@extends('layouts.app')

@section('title', $pole->nom . ' - SmartPole')

@section('content')
    <h1>{{ $pole->nom }}</h1>

    <p><strong>Description :</strong> {{ $pole->description }}</p>
    <p><strong>Responsable :</strong> {{ $pole->manager->nom }}</p>

    <h2>Ventes liées à ce pôle</h2>
    @if ($pole->ventes->isEmpty())
        <p>Aucune vente enregistrée pour ce pôle.</p>
    @else
        <ul>
            @foreach ($pole->ventes as $vente)
                <li>{{ $vente->date }} — {{ $vente->montant }} €</li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('poles.edit', $pole->pole_id) }}">Modifier</a>
    |
    <a href="{{ route('poles.index') }}">Retour à la liste</a>
@endsection