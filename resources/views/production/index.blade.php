@extends('layouts.app')

@section('title', 'Liste de la production - SmartPole')

@section('content')
    <h1>Liste de la production</h1>

    <button type="button" class="link-button" onclick="ouvrirModalAjout()">+ Ajouter une production</button>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Date</th>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Pôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productions as $production)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($production->date)->format('d/m/Y') }}</td>
                    <td>{{ $production->produit }}</td>
                    <td>{{ $production->quantite }}</td>
                    <td>{{ $production->pole->nom }}</td>
                    <td>
                        <a href="{{ route('production.show', $production->production_id) }}">Voir</a>
                        <button type="button" class="link-button" onclick="ouvrirModalModif(
                            {{ $production->production_id }},
                            '{{ \Carbon\Carbon::parse($production->date)->format('Y-m-d') }}',
                            '{{ addslashes($production->produit) }}',
                            {{ $production->quantite }},
                            {{ $production->pole_id }}
                        )">Modifier</button>
                        <form action="{{ route('production.destroy', $production->production_id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Supprimer cette production ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Modal Ajouter / Modifier une production --}}
    <div id="productionModal" class="modal-overlay">
        <div class="modal-box">
            <h2 id="modalTitle">Ajouter une production</h2>

            <form id="productionForm" method="POST" action="">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="form-group">
                    <label for="modal_date">Date :</label>
                    <input type="date" name="date" id="modal_date" required>
                </div>

                <div class="form-group">
                    <label for="modal_produit">Produit :</label>
                    <input type="text" name="produit" id="modal_produit" required>
                </div>

                <div class="form-group">
                    <label for="modal_quantite">Quantité :</label>
                    <input type="number" name="quantite" id="modal_quantite" required>
                </div>

                <div class="form-group">
                    <label for="modal_pole_id">Pôle :</label>
                    <select name="pole_id" id="modal_pole_id" required>
                        @foreach ($poles as $pole)
                            <option value="{{ $pole->pole_id }}">{{ $pole->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-actions">
                    <button type="submit">Enregistrer</button>
                    <button type="button" onclick="fermerModal()">Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .link-button {
            background: none;
            border: none;
            color: #1d4ed8;
            text-decoration: underline;
            cursor: pointer;
            padding: 0;
            font: inherit;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-box {
            background: white;
            padding: 24px;
            border-radius: 8px;
            width: 90%;
            max-width: 420px;
        }

        .modal-box .form-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-bottom: 12px;
        }

        .modal-actions {
            display: flex;
            gap: 8px;
            margin-top: 16px;
        }
    </style>

    <script>
        function ouvrirModalAjout() {
            document.getElementById('modalTitle').innerText = 'Ajouter une production';
            document.getElementById('productionForm').action = "{{ route('production.store') }}";
            document.getElementById('formMethod').value = 'POST';

            document.getElementById('modal_date').value = '';
            document.getElementById('modal_produit').value = '';
            document.getElementById('modal_quantite').value = '';
            document.getElementById('modal_pole_id').selectedIndex = 0;

            document.getElementById('productionModal').style.display = 'flex';
        }

        function ouvrirModalModif(id, date, produit, quantite, poleId) {
            document.getElementById('modalTitle').innerText = 'Modifier la production';

            const baseUrl = "{{ url('/production') }}";
            document.getElementById('productionForm').action = baseUrl + '/' + id;
            document.getElementById('formMethod').value = 'PUT';

            document.getElementById('modal_date').value = date;
            document.getElementById('modal_produit').value = produit;
            document.getElementById('modal_quantite').value = quantite;
            document.getElementById('modal_pole_id').value = poleId;

            document.getElementById('productionModal').style.display = 'flex';
        }

        function fermerModal() {
            document.getElementById('productionModal').style.display = 'none';
        }
    </script>
@endsection