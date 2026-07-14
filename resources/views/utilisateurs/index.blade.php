@extends('layouts.app')

@section('title', 'Liste des utilisateurs - SmartPole')

@section('content')
    <h1>Liste des utilisateurs</h1>

    <button type="button" class="link-button" onclick="ouvrirModalAjout()">+ Ajouter un utilisateur</button>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($utilisateurs as $utilisateur)
                <tr>
                    <td>{{ $utilisateur->nom }}</td>
                    <td>{{ $utilisateur->email }}</td>
                    <td>{{ $utilisateur->role }}</td>
                    <td>
                        @if($utilisateur->statut)
                            <span style="color: green; font-weight: bold;">Actif</span>
                        @else
                            <span style="color: red; font-weight: bold;">Désactivé</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('utilisateurs.show', $utilisateur->utilisateur_id) }}">Voir</a>
                        <button type="button" class="link-button" onclick="ouvrirModalModif(
                            {{ $utilisateur->utilisateur_id }},
                            '{{ addslashes($utilisateur->nom) }}',
                            '{{ addslashes($utilisateur->email) }}',
                            '{{ $utilisateur->role }}'
                        )">Modifier</button>

                        @if($utilisateur->statut)
                            <form action="{{ route('utilisateurs.desactiver', $utilisateur->utilisateur_id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" onclick="return confirm('Désactiver cet utilisateur ?')" style="color:red;">Désactiver</button>
                            </form>
                        @else
                            <form action="{{ route('utilisateurs.reactiver', $utilisateur->utilisateur_id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" onclick="return confirm('Réactiver cet utilisateur ?')" style="color:green;">Réactiver</button>
                            </form>
                        @endif

                        <form action="{{ route('utilisateurs.destroy', $utilisateur->utilisateur_id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Modal Ajouter / Modifier un utilisateur --}}
    <div id="utilisateurModal" class="modal-overlay">
        <div class="modal-box">
            <h2 id="modalTitle">Ajouter un utilisateur</h2>

            <form id="utilisateurForm" method="POST" action="">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="form-group">
                    <label for="modal_nom">Nom :</label>
                    <input type="text" name="nom" id="modal_nom" required>
                </div>

                <div class="form-group">
                    <label for="modal_email">Email :</label>
                    <input type="email" name="email" id="modal_email" required>
                </div>

                <div class="form-group">
                    <label for="modal_mot_de_passe" id="modal_password_label">Mot de passe :</label>
                    <input type="password" name="mot_de_passe" id="modal_mot_de_passe">
                </div>

                <div class="form-group">
                    <label for="modal_role">Rôle :</label>
                    <select name="role" id="modal_role" required>
                        <option value="administrateur">Administrateur</option>
                        <option value="responsable">Responsable de pôle</option>
                        <option value="direction">Direction</option>
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
            document.getElementById('modalTitle').innerText = 'Ajouter un utilisateur';
            document.getElementById('utilisateurForm').action = "{{ route('utilisateurs.store') }}";
            document.getElementById('formMethod').value = 'POST';

            document.getElementById('modal_nom').value = '';
            document.getElementById('modal_email').value = '';
            document.getElementById('modal_mot_de_passe').value = '';
            document.getElementById('modal_mot_de_passe').required = true;
            document.getElementById('modal_password_label').innerText = 'Mot de passe :';
            document.getElementById('modal_role').selectedIndex = 0;

            document.getElementById('utilisateurModal').style.display = 'flex';
        }

        function ouvrirModalModif(id, nom, email, role) {
            document.getElementById('modalTitle').innerText = 'Modifier l\'utilisateur';

            const baseUrl = "{{ url('/utilisateurs') }}";
            document.getElementById('utilisateurForm').action = baseUrl + '/' + id;
            document.getElementById('formMethod').value = 'PUT';

            document.getElementById('modal_nom').value = nom;
            document.getElementById('modal_email').value = email;
            document.getElementById('modal_mot_de_passe').value = '';
            document.getElementById('modal_mot_de_passe').required = false;
            document.getElementById('modal_password_label').innerText = 'Nouveau mot de passe (laisser vide pour ne pas changer) :';
            document.getElementById('modal_role').value = role;

            document.getElementById('utilisateurModal').style.display = 'flex';
        }

        function fermerModal() {
            document.getElementById('utilisateurModal').style.display = 'none';
        }
    </script>
@endsection