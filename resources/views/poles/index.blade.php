@extends('layouts.app')

@section('title', 'Liste des pôles - SmartPole')

@section('content')
    <h1>Liste des pôles</h1>

    <button type="button" class="link-button" onclick="ouvrirModalAjout()">+ Ajouter un pôle</button>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Responsable</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($poles as $pole)
                <tr>
                    <td>{{ $pole->nom }}</td>
                    <td>{{ $pole->description }}</td>
                    <td>{{ $pole->manager->nom }}</td>
                    <td>
                        <a href="{{ route('poles.show', $pole->pole_id) }}">Voir</a>
                        <button
                            type="button"
                            class="link-button"
                            onclick="ouvrirModalModif(this)"
                            data-id="{{ $pole->pole_id }}"
                            data-nom="{{ $pole->nom }}"
                            data-description="{{ $pole->description }}"
                            data-manager="{{ $pole->manager_id }}"
                        >Modifier</button>
                        <form action="{{ route('poles.destroy', $pole->pole_id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Supprimer ce pôle ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Modal Ajouter / Modifier un pôle --}}
    <div id="poleModal" class="modal-overlay">
        <div class="modal-box">
            <h2 id="modalTitle">Ajouter un pôle</h2>

            <form id="poleForm" method="POST" action="">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="form-group">
                    <label for="modal_nom">Nom :</label>
                    <input type="text" name="nom" id="modal_nom" required>
                </div>

                <div class="form-group">
                    <label for="modal_description">Description :</label>
                    <textarea name="description" id="modal_description" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="modal_manager_id">Responsable :</label>
                    <select name="manager_id" id="modal_manager_id" required>
                        @foreach ($managers as $manager)
                            <option value="{{ $manager->utilisateur_id }}">{{ $manager->nom }}</option>
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

        .modal-box textarea {
            font-family: inherit;
            padding: 6px 8px;
        }

        .modal-actions {
            display: flex;
            gap: 8px;
            margin-top: 16px;
        }
    </style>

    <script>
        function ouvrirModalAjout() {
            document.getElementById('modalTitle').innerText = 'Ajouter un pôle';
            document.getElementById('poleForm').action = "{{ route('poles.store') }}";
            document.getElementById('formMethod').value = 'POST';

            document.getElementById('modal_nom').value = '';
            document.getElementById('modal_description').value = '';
            document.getElementById('modal_manager_id').selectedIndex = 0;

            document.getElementById('poleModal').style.display = 'flex';
        }

        function ouvrirModalModif(bouton) {
            document.getElementById('modalTitle').innerText = 'Modifier le pôle';

            const id = bouton.dataset.id;
            const baseUrl = "{{ url('/poles') }}";
            document.getElementById('poleForm').action = baseUrl + '/' + id;
            document.getElementById('formMethod').value = 'PUT';

            document.getElementById('modal_nom').value = bouton.dataset.nom;
            document.getElementById('modal_description').value = bouton.dataset.description;
            document.getElementById('modal_manager_id').value = bouton.dataset.manager;

            document.getElementById('poleModal').style.display = 'flex';
        }

        function fermerModal() {
            document.getElementById('poleModal').style.display = 'none';
        }
    </script>
@endsection