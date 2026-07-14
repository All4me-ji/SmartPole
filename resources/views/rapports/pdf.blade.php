<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport des ventes - SmartPole</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #2E4057; color: white; }
        .recap { margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Rapport des ventes - SmartPole</h1>
    <p>Date de génération : {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Pôle</th>
                <th>Montant (€)</th>
                <th>Coût (€)</th>
                <th>Bénéfice (€)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventes as $vente)
                <tr>
                    <td>{{ $vente->date }}</td>
                    <td>{{ $vente->pole->nom }}</td>
                    <td>{{ $vente->montant }}</td>
                    <td>{{ $vente->cout }}</td>
                    <td>{{ $vente->benefice }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="recap">
        Total des ventes : {{ $totalVentes }} € — Total des bénéfices : {{ $totalBenefices }} €
    </p>
</body>
</html>