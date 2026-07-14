@extends('layouts.app')

@section('title', 'Liste des objectifs - SmartPole')

@section('content')
    <h1>Liste des objectifs</h1>

    <button type="button" class="link-button" onclick="ouvrirModalAjout()">+ Ajouter un objectif</button>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Cible</th>
                <th>Période</th>
                <th>Pôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($objectifs as $objectif)
                <tr>
                    <td>{{ $objectif->cible }}</td>
                    <td>{{ $objectif->periode }}</td>
                    <td>{{ $objectif->pole->nom }}</td>
                    <td>
                        <a href="{{ route('objectifs.show', $objectif->objectif_id) }}">Voir</a>
                        <button type="button" class="link-button" onclick="ouvrirModalModif(
                            {{ $objectif->objectif_id }},
                            {{ $objectif->cible }},
                            '{{ addslashes($objectif->periode) }}',
                            {{ $objectif->pole_id }}
                        )">Modifier</button>
                        <form action="{{ route('objectifs.destroy', $objectif->objectif_id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Supprimer cet objectif ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Modal Ajouter / Modifier un objectif --}}
    <div id="objectifModal" class="modal-overlay">
        <div class="modal-box">
            <h2 id="modalTitle">Ajouter un objectif</h2>

            <form id="objectifForm" method="POST" action="">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="form-group">
                    <label for="modal_cible">Cible :</label>
                    <input type="number" step="0.01" name="cible" id="modal_cible" required>
                </div>

                <div class="form-group">
                    <label for="modal_periode">Période :</label>
                    <input type="text" name="periode" id="modal_periode" placeholder="ex: Janvier 2026" required>
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
            document.getElementById('modalTitle').innerText = 'Ajouter un objectif';
            document.getElementById('objectifForm').action = "{{ route('objectifs.store') }}";
            document.getElementById('formMethod').value = 'POST';

            document.getElementById('modal_cible').value = '';
            document.getElementById('modal_periode').value = '';
            document.getElementById('modal_pole_id').selectedIndex = 0;

            document.getElementById('objectifModal').style.display = 'flex';
        }

        function ouvrirModalModif(id, cible, periode, poleId) {
            document.getElementById('modalTitle').innerText = "Modifier l'objectif";

            const baseUrl = "{{ url('/objectifs') }}";
            document.getElementById('objectifForm').action = baseUrl + '/' + id;
            document.getElementById('formMethod').value = 'PUT';

            document.getElementById('modal_cible').value = cible;
            document.getElementById('modal_periode').value = periode;
            document.getElementById('modal_pole_id').value = poleId;

            document.getElementById('objectifModal').style.display = 'flex';
        }

        function fermerModal() {
            document.getElementById('objectifModal').style.display = 'none';
        }
    </script>
@endsection