@extends('layouts.app')

    @section('title', 'Objectif - SmartPole')

@section('content')
    <h1>Détail de l'objectif</h1>

    <p><strong>Cible :</strong> {{ $objectif->cible }}</p>
    <p><strong>Période :</strong> {{ $objectif->periode }}</p>
    <p><strong>Pôle :</strong> {{ $objectif->pole->nom }}</p>

    <a href="{{ route('objectifs.edit', $objectif->objectif_id) }}">Modifier</a>
    |
    <a href="{{ route('objectifs.index') }}">Retour à la liste</a>
@endsection