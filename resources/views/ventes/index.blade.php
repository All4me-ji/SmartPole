@extends('layouts.app')

@section('title', 'Liste des ventes - SmartPole')

@section('content')
    <h1>Liste des ventes</h1>

    {{-- Formulaire de filtres --}}
    <form method="GET" action="{{ route('ventes.index') }}" class="filters-form">
        <div class="filter-group">
            <label for="pole_id">Pôle :</label>
            <select name="pole_id" id="pole_id">
                <option value="">-- Tous les pôles --</option>
                @foreach ($poles as $pole)
                    <option value="{{ $pole->pole_id }}" @if(request('pole_id') == $pole->pole_id) selected @endif>
                        {{ $pole->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label for="date_debut">Du :</label>
            <input type="date" name="date_debut" id="date_debut" value="{{ request('date_debut') }}">
        </div>

        <div class="filter-group">
            <label for="date_fin">Au :</label>
            <input type="date" name="date_fin" id="date_fin" value="{{ request('date_fin') }}">
        </div>

        <div class="filter-group">
            <label for="montant_min">Montant min :</label>
            <input type="number" name="montant_min" id="montant_min" value="{{ request('montant_min') }}" step="0.01">
        </div>

        <div class="filter-actions">
            <button type="submit">Filtrer</button>
            <a href="{{ route('ventes.index') }}">Réinitialiser</a>
        </div>
    </form>

    <button type="button" onclick="ouvrirModalAjout()" class="link-button">+ Ajouter une vente</button>

    <p>{{ $ventes->count() }} vente(s) trouvée(s)</p>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Date</th>
                <th>Montant</th>
                <th>Coût</th>
                <th>Bénéfice</th>
                <th>Pôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ventes as $vente)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($vente->date)->format('d/m/Y') }}</td>
                    <td>{{ $vente->montant }} dh</td>
                    <td>{{ $vente->cout }} dh</td>
                    <td>{{ $vente->benefice }} dh</td>
                    <td>{{ $vente->pole->nom }}</td>
                    <td>
                        <a href="{{ route('ventes.show', $vente->vente_id) }}">Voir</a>
                        <button type="button" class="link-button" onclick="ouvrirModalModif(
                            {{ $vente->vente_id }},
                            '{{ \Carbon\Carbon::parse($vente->date)->format('Y-m-d') }}',
                            {{ $vente->montant }},
                            {{ $vente->cout }},
                            {{ $vente->benefice }},
                            {{ $vente->pole_id }}
                        )">Modifier</button>
                        <form action="{{ route('ventes.destroy', $vente->vente_id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Supprimer cette vente ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">Aucune vente trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Modal Ajouter / Modifier une vente --}}
    <div id="venteModal" class="modal-overlay">
        <div class="modal-box">
            <h2 id="modalTitle">Ajouter une vente</h2>

            <form id="venteForm" method="POST" action="">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="form-group">
                    <label for="modal_date">Date :</label>
                    <input type="date" name="date" id="modal_date" required>
                </div>

                <div class="form-group">
                    <label for="modal_montant">Montant :</label>
                    <input type="number" step="0.01" name="montant" id="modal_montant" oninput="calculerBeneficeModal()" required>
                </div>

                <div class="form-group">
                    <label for="modal_cout">Coût :</label>
                    <input type="number" step="0.01" name="cout" id="modal_cout" oninput="calculerBeneficeModal()" required>
                </div>

                <div class="form-group">
                    <label for="modal_benefice">Bénéfice :</label>
                    <input type="number" step="0.01" name="benefice" id="modal_benefice" readonly style="background-color:#f0f0f0">
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
        .filters-form {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 16px;
            margin-bottom: 20px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .filter-group label {
            font-size: 0.85rem;
            font-weight: 600;
        }

        .filter-group select,
        .filter-group input {
            padding: 6px 8px;
        }

        .filter-actions {
            display: flex;
            gap: 8px;
        }

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
        function calculerBeneficeModal() {
            const montant = parseFloat(document.getElementById('modal_montant').value) || 0;
            const cout = parseFloat(document.getElementById('modal_cout').value) || 0;
            document.getElementById('modal_benefice').value = (montant - cout).toFixed(2);
        }

        function ouvrirModalAjout() {
            document.getElementById('modalTitle').innerText = 'Ajouter une vente';
            document.getElementById('venteForm').action = "{{ route('ventes.store') }}";
            document.getElementById('formMethod').value = 'POST';

            document.getElementById('modal_date').value = '';
            document.getElementById('modal_montant').value = '';
            document.getElementById('modal_cout').value = '';
            document.getElementById('modal_benefice').value = '';
            document.getElementById('modal_pole_id').selectedIndex = 0;

            document.getElementById('venteModal').style.display = 'flex';
        }

        function ouvrirModalModif(id, date, montant, cout, benefice, poleId) {
            document.getElementById('modalTitle').innerText = 'Modifier la vente';

            const baseUrl = "{{ url('/ventes') }}";
            document.getElementById('venteForm').action = baseUrl + '/' + id;
            document.getElementById('formMethod').value = 'PUT';

            document.getElementById('modal_date').value = date;
            document.getElementById('modal_montant').value = montant;
            document.getElementById('modal_cout').value = cout;
            document.getElementById('modal_benefice').value = benefice;
            document.getElementById('modal_pole_id').value = poleId;

            document.getElementById('venteModal').style.display = 'flex';
        }

        function fermerModal() {
            document.getElementById('venteModal').style.display = 'none';
        }
    </script>
@endsection