@extends('layouts.app')

@section('title', 'Prédictions - ' . $pole->nom)

@section('content')
    <h1>Prévisions de ventes — {{ $pole->nom }}</h1>

    @if(!empty($resultat['tendance']))
        <div style="background-color:#cff4fc; color:#055160; border:1px solid #b6effb; padding:10px; margin-bottom:15px; border-radius:4px;">
            <strong>Tendance observée :</strong> {{ $resultat['tendance'] }}
        </div>
    @endif

    @if(!empty($resultat['metriques']))
        <div style="background-color:#f0f4f8; color:#16324F; border:1px solid #d6dee6; padding:10px; margin-bottom:15px; border-radius:4px;">
            <strong>Qualité du modèle :</strong>
            R² = {{ $resultat['metriques']['r2'] }}
            | MAE = {{ number_format($resultat['metriques']['mae'], 0, ',', ' ') }} dh
            | RMSE = {{ number_format($resultat['metriques']['rmse'], 0, ',', ' ') }} dh
        </div>
    @endif


    @if($resultat['message'])
        <div style="background-color:#fff3cd; color:#664d03; border:1px solid #ffecb5; padding:10px; border-radius:4px;">
            {{ $resultat['message'] }}
        </div>
    @else
        <canvas id="chartPrediction" width="700" height="350"></canvas>

        <h2>Détail des prévisions</h2>
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Période</th>
                    <th>Montant prévu</th>
                    <th>Évolution</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $dernierMontantReel = $resultat['historique']->last()->total ?? null;
                @endphp
                @foreach ($resultat['predictions'] as $index => $prediction)
                    @php
                        $precedent = $index === 0 ? $dernierMontantReel : $resultat['predictions'][$index - 1];
                        $ecart = $precedent !== null ? $prediction - $precedent : null;
                    @endphp
                    <tr>
                        <td>Mois +{{ $index + 1 }}</td>
                        <td>{{ number_format($prediction, 2, ',', ' ') }} dh</td>
                        <td>
                            @if($ecart !== null)
                                @if($ecart >= 0)
                                    <span style="color: #1F9D55; font-weight: bold;">+{{ number_format($ecart, 2, ',', ' ') }} dh</span>
                                @else
                                    <span style="color: #C0392B; font-weight: bold;">{{ number_format($ecart, 2, ',', ' ') }} dh</span>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p style="font-size:0.85rem; color:#5B6573;">
            La colonne "Évolution" indique la variation par rapport à la période précédente.
        </p>

        <p><em>Prévisions générées à l'aide d'un modèle de régression linéaire simple, basé sur l'historique des ventes mensuelles du pôle.</em></p>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
        <script>
            const historiqueLabels = @json($resultat['historique']->pluck('mois'));
            const historiqueData = @json($resultat['historique']->pluck('total'));
            const predictions = @json($resultat['predictions']);

            // Labels pour les mois futurs (Mois +1, Mois +2...)
            const predictionLabels = predictions.map((_, i) => 'Mois +' + (i + 1));
            const allLabels = [...historiqueLabels, ...predictionLabels];

            // On complète l'historique avec des "null" pour la partie future, et vice versa
            const historiqueComplet = [...historiqueData, ...Array(predictions.length).fill(null)];
            const predictionsCompletes = [...Array(historiqueData.length - 1).fill(null), historiqueData[historiqueData.length - 1], ...predictions];

            new Chart(document.getElementById('chartPrediction'), {
                type: 'line',
                data: {
                    labels: allLabels,
                    datasets: [
                        {
                            label: 'Historique réel',
                            data: historiqueComplet,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            tension: 0.3
                        },
                        {
                            label: 'Prévision',
                            data: predictionsCompletes,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderDash: [5, 5],
                            tension: 0.3
                        }
                    ]
                }
            });
        </script>
    @endif

    <a href="{{ route('predictions.index') }}">Retour à la liste</a>
@endsection