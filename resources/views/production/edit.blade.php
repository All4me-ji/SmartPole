@extends('layouts.app')


    @section('title' ,'Modifier la production - SmartPole')

@section('content')
    <h1>Modifier la production</h1>

    <form method="POST" action="{{ route('production.update', $production->production_id) }}">
        @csrf
        @method('PUT')

        <label for="date">Date :</label><br>
        <input type="date" name="date" id="date" value="{{ $production->date }}"><br><br>

        <label for="produit">Produit :</label><br>
        <input type="text" name="produit" id="produit" value="{{ $production->produit }}"><br><br>

        <label for="quantite">Quantité :</label><br>
        <input type="number" name="quantite" id="quantite" value="{{ $production->quantite }}"><br><br>

        <label for="pole_id">Pôle :</label><br>
        <select name="pole_id" id="pole_id">
            @foreach ($poles as $pole)
                <option value="{{ $pole->pole_id }}" @if($pole->pole_id == $production->pole_id) selected @endif>{{ $pole->nom }}</option>
            @endforeach
        </select><br><br>

        <button type="submit">Mettre à jour</button>
    </form>

    <a href="{{ route('production.index') }}">Retour à la liste</a>
@endsection