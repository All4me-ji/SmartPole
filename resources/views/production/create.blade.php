@extends('layouts.app')

    @section('title', 'Ajouter une production - SmartPole')

@section('content')
    <h1>Ajouter une production</h1>

    <form method="POST" action="{{ route('production.store') }}">
        @csrf

        <label for="date">Date :</label><br>
        <input type="date" name="date" id="date"><br><br>

        <label for="produit">Produit :</label><br>
        <input type="text" name="produit" id="produit"><br><br>

        <label for="quantite">Quantité :</label><br>
        <input type="number" name="quantite" id="quantite"><br><br>

        <label for="pole_id">Pôle :</label><br>
        <select name="pole_id" id="pole_id">
            @foreach ($poles as $pole)
                <option value="{{ $pole->pole_id }}">{{ $pole->nom }}</option>
            @endforeach
        </select><br><br>

        <button type="submit">Enregistrer</button>
    </form>

    <a href="{{ route('production.index') }}">Retour à la liste</a>
@endsection