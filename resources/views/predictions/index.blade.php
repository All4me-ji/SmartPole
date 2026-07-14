@extends('layouts.app')

@section('title', 'Prédictions IA - SmartPole')

@section('content')
    <h1>Module de prédiction IA</h1>
    <p>Sélectionnez un pôle pour visualiser les prévisions de ventes basées sur l'historique enregistré.</p>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Pôle</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($poles as $pole)
                <tr>
                    <td>{{ $pole->nom }}</td>
                    <td><a href="{{ route('predictions.show', $pole->pole_id) }}">Voir les prévisions</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection