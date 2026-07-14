@extends('layouts.app')

    @section('title', 'Vente du {{ \Carbon\Carbon::parse($vente->date)->format('d/m/Y') }} - SmartPole')

@section('content')
    <h1>Vente du {{ \Carbon\Carbon::parse($vente->date)->format('d/m/Y') }}</h1>

    <p><strong>Montant :</strong> {{ $vente->montant }} dh</p>
    <p><strong>Coût :</strong> {{ $vente->cout }} dh</p>
    <p><strong>Bénéfice :</strong> {{ $vente->benefice }} dh</p>
    <p><strong>Pôle :</strong> {{ $vente->pole->nom }}</p>

    <a href="{{ route('ventes.edit', $vente->vente_id) }}">Modifier</a>
    |
    <a href="{{ route('ventes.index') }}">Retour à la liste</a>
@endsection