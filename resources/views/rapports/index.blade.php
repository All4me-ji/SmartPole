@extends('layouts.app')

@section('title', 'Rapports - SmartPole')

@section('content')
    <h1>Génération de rapports</h1>

    <h2>Rapport global</h2>
    <a href="{{ route('rapports.pdf') }}">Télécharger en PDF</a>
    |
    <a href="{{ route('rapports.excel') }}">Télécharger en Excel</a>

    <h2>Rapport par pôle</h2>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Pôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($poles as $pole)
                <tr>
                    <td>{{ $pole->nom }}</td>
                    <td>
                        <a href="{{ route('rapports.pdf', $pole->pole_id) }}">PDF</a>
                        |
                        <a href="{{ route('rapports.excel', $pole->pole_id) }}">Excel</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection