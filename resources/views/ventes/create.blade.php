@extends('layouts.app')


    @section('title', 'Ajouter une vente - SmartPole')


@section('content')
    <h1>Ajouter une vente</h1>

    <form method="POST" action="{{ route('ventes.store') }}">
        @csrf

        <label for="date">Date :</label><br>
        <input type="date" name="date" id="date"><br><br>

        <label for="montant">Montant :</label><br>
	<input type="number" step="0.01" name="montant" id="montant" oninput="calculerBenefice()"><br><br>

	<label for="cout">Coût :</label><br>
	<input type="number" step="0.01" name="cout" id="cout" oninput="calculerBenefice()"><br><br>

	<label for="benefice">Bénéfice :</label><br>
	<input type="number" step="0.01" name="benefice" id="benefice" readonly style="background-color:#f0f0f0"><br><br>

<script>
    function calculerBenefice() {
        const montant = parseFloat(document.getElementById('montant').value) || 0;
        const cout = parseFloat(document.getElementById('cout').value) || 0;
        document.getElementById('benefice').value = (montant - cout).toFixed(2);
    }
</script>

        <label for="pole_id">Pôle :</label><br>
        <select name="pole_id" id="pole_id">
            @foreach ($poles as $pole)
                <option value="{{ $pole->pole_id }}">{{ $pole->nom }}</option>
            @endforeach
        </select><br><br>

        <button type="submit">Enregistrer</button>
    </form>

    <a href="{{ route('ventes.index') }}">Retour à la liste</a>
@endsection