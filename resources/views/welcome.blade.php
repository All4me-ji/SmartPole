@extends('layouts.app')

@section('title', 'SmartPole - Accueil')

@section('content')
    <h1>SmartPole</h1>
    <p>Bienvenue, {{ Auth::user()->nom }}. Centralisez vos ventes, votre production et vos objectifs par pôle.</p>

    <div class="card-grid">
        <a href="{{ route('dashboard') }}" class="card">
            <div class="card-title">Tableau de bord</div>
            <div class="card-desc">KPI, marges, alertes et graphiques de performance</div>
        </a>

        @if(in_array(Auth::user()->role, ['administrateur', 'direction']))
            <a href="{{ route('poles.index') }}" class="card">
                <div class="card-title">Pôles</div>
                <div class="card-desc">Gérer les pôles et leurs responsables</div>
            </a>
        @endif

        @if(Auth::user()->role == 'administrateur')
            <a href="{{ route('utilisateurs.index') }}" class="card">
                <div class="card-title">Utilisateurs</div>
                <div class="card-desc">Comptes, rôles et accès</div>
            </a>
        @endif

        <a href="{{ route('ventes.index') }}" class="card">
            <div class="card-title">Ventes</div>
            <div class="card-desc">Historique, filtres et bénéfices</div>
        </a>

        <a href="{{ route('objectifs.index') }}" class="card">
            <div class="card-title">Objectifs</div>
            <div class="card-desc">Cibles par pôle et par période</div>
        </a>

        <a href="{{ route('production.index') }}" class="card">
            <div class="card-title">Production</div>
            <div class="card-desc">Suivi des quantités produites</div>
        </a>

        <a href="{{ route('rapports.index') }}" class="card">
            <div class="card-title">Rapports</div>
            <div class="card-desc">Export PDF et Excel par pôle</div>
        </a>

        <a href="{{ route('predictions.index') }}" class="card">
            <div class="card-title">Prédictions IA</div>
            <div class="card-desc">Prévisions de ventes basées sur l'historique</div>
        </a>
    </div>
@endsection