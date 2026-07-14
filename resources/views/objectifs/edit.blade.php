@extends('layouts.app')

    @section('title', "Modifier l'objectif - SmartPole")

@section('content')
    <h1>Modifier l'objectif</h1>

    <form method="POST" action="{{ route('objectifs.update', $objectif->objectif_id) }}">
        @csrf
        @method('PUT')

        <label for="cible">Cible :</label><br>
        <input type="number" step="0.01" name="cible" id="cible" value="{{ $objectif->cible }}"><br><br>

        <label for="periode">Période :</label><br>
        <input type="text" name="periode" id="periode" value="{{ $objectif->periode }}"><br><br>

        <label for="pole_id">Pôle :</label><br>
        <select name="pole_id" id="pole_id">
            @foreach ($poles as $pole)
                <option value="{{ $pole->pole_id }}" @if($pole->pole_id == $objectif->pole_id) selected @endif>{{ $pole->nom }}</option>
            @endforeach
        </select><br><br>

        <button type="submit">Mettre à jour</button>
    </form>

    <a href="{{ route('objectifs.index') }}">Retour à la liste</a>
@endsection