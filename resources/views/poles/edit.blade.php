@extends('layouts.app')

@section('title', 'Modifier ' . $pole->nom . ' - SmartPole')

@section('content')
    <h1>Modifier le pôle</h1>

    <form method="POST" action="{{ route('poles.update', $pole->pole_id) }}">
        @csrf
        @method('PUT')

        <label for="nom">Nom :</label><br>
        <input type="text" name="nom" id="nom" value="{{ $pole->nom }}"><br><br>

        <label for="description">Description :</label><br>
        <textarea name="description" id="description">{{ $pole->description }}</textarea><br><br>

        <label for="manager_id">Responsable :</label><br>
        <select name="manager_id" id="manager_id">
            @foreach ($managers as $manager)
                <option value="{{ $manager->utilisateur_id }}" @if ($manager->utilisateur_id == $pole->manager_id) selected @endif>
                    {{ $manager->nom }}
                </option>
            @endforeach
        </select><br><br>

        <button type="submit">Mettre à jour</button>
    </form>

    <a href="{{ route('poles.index') }}">Retour à la liste</a>
@endsection