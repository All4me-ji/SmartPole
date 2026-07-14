@extends('layouts.app')

    @section('title', 'Production - SmartPole')

@section('content')
    <h1>Détail de la production</h1>

    <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($production->date)->format('d/m/Y') }}</p>
    <p><strong>Produit :</strong> {{ $production->produit }}</p>
    <p><strong>Quantité :</strong> {{ $production->quantite }}</p>
    <p><strong>Pôle :</strong> {{ $production->pole->nom }}</p>

    <a href="{{ route('production.edit', $production->production_id) }}">Modifier</a>
    |
    <a href="{{ route('production.index') }}">Retour à la liste</a>
@endsection