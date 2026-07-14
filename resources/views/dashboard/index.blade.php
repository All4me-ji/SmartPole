@extends('layouts.app')

@section('title', 'Tableau de bord - SmartPole')

@section('content')
    <h1>Tableau de bord</h1>
<br><br>

{{-- Taux de croissance --}}
<div style="display:inline-block; background:white; border:1px solid #E2E5EA; border-radius:10px; padding:1rem 1.5rem; margin-bottom:1.5rem; box-shadow:0 1px 2px rgba(0,0,0,0.06);">
    <div style="font-size:0.85rem; color:#5B6573; font-weight:600; text-transform:uppercase; letter-spacing:0.03em;">Taux de croissance</div>
    @if($tauxCroissance === null)
        <div style="font-size:1.5rem; font-weight:700; color:#5B6573;">N/A</div>
        <div style="font-size:0.8rem; color:#5B6573;">
            Pas de données le mois précédent pour comparer
            ({{ number_format($ventesMoisActuel, 0, ',', ' ') }} dh de ventes ce mois-ci)
        </div>
    @elseif($tauxCroissance >= 0)
        <div style="font-size:1.5rem; font-weight:700; color:#1F9D55;">+{{ $tauxCroissance }} %</div>
        <div style="font-size:0.8rem; color:#5B6573;">
            {{ number_format($ventesMoisActuel, 0, ',', ' ') }} dh ce mois-ci
            contre {{ number_format($ventesMoisPrecedent, 0, ',', ' ') }} dh le mois précédent
        </div>
    @else
        <div style="font-size:1.5rem; font-weight:700; color:#C0392B;">{{ $tauxCroissance }} %</div>
        <div style="font-size:0.8rem; color:#5B6573;">
            {{ number_format($ventesMoisActuel, 0, ',', ' ') }} dh ce mois-ci
            contre {{ number_format($ventesMoisPrecedent, 0, ',', ' ') }} dh le mois précédent
        </div>
    @endif
</div>

{{-- Alertes --}}
@if(count($alertes) > 0)
    <h2>Alertes</h2>
    @foreach ($alertes as $alerte)
        @if($alerte['type'] == 'danger')
            <div style="background-color:#f8d7da; color:#842029; border:1px solid #f5c2c7; padding:10px; margin-bottom:8px; border-radius:4px;">
                <strong>Alerte :</strong> {{ $alerte['message'] }}
            </div>
        @elseif($alerte['type'] == 'warning')
            <div style="background-color:#fff3cd; color:#664d03; border:1px solid #ffecb5; padding:10px; margin-bottom:8px; border-radius:4px;">
                <strong>Attention :</strong> {{ $alerte['message'] }}
            </div>
        @else
            <div style="background-color:#cff4fc; color:#055160; border:1px solid #b6effb; padding:10px; margin-bottom:8px; border-radius:4px;">
                <strong>Info :</strong> {{ $alerte['message'] }}
            </div>
        @endif
    @endforeach
@else
    <div style="background-color:#d1e7dd; color:#0f5132; border:1px solid #badbcc; padding:10px; margin-bottom:8px; border-radius:4px;">
        Aucune alerte. Toutes les performances sont dans les normes.
    </div>
@endif

    {{-- Performance commerciale --}}
    <h2>Performance commerciale par pôle</h2>
    @if(in_array('commercial', $typesPoles))
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Pôle</th>
                    <th>Nombre de ventes</th>
                    <th>Total Ventes</th>
                    <th>Total Coûts</th>
                    <th>Total Bénéfices</th>
                    <th>Marge brute (%)</th>
                    <th>Taux d'atteinte (%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($labels as $index => $label)
                    @if($typesPoles[$index] === 'commercial')
                        <tr>
                            <td>{{ $label }}</td>
                            <td>{{ $nombreVentes[$index] }}</td>
                            <td>{{ $totalVentes[$index] }} dh</td>
                            <td>{{ $totalCouts[$index] }} dh</td>
                            <td>{{ $totalBenefices[$index] }} dh</td>
                            <td>
                                @if($margesBrutes[$index] >= 20)
                                    <span style="color: green; font-weight: bold;">{{ $margesBrutes[$index] }} %</span>
                                @elseif($margesBrutes[$index] >= 10)
                                    <span style="color: orange; font-weight: bold;">{{ $margesBrutes[$index] }} %</span>
                                @else
                                    <span style="color: red; font-weight: bold;">{{ $margesBrutes[$index] }} %</span>
                                @endif
                            </td>
                            <td>
                                @if($tauxAtteinte[$index] >= 100)
                                    <span style="color: green; font-weight: bold;">{{ $tauxAtteinte[$index] }} %</span>
                                @elseif($tauxAtteinte[$index] >= 75)
                                    <span style="color: orange; font-weight: bold;">{{ $tauxAtteinte[$index] }} %</span>
                                @else
                                    <span style="color: red; font-weight: bold;">{{ $tauxAtteinte[$index] }} %</span>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
                <tr style="font-weight: bold; background-color: #2E4057; color: white;">
                    <td>TOTAL GLOBAL</td>
                    <td>-</td>
                    <td>{{ $totalVentesGlobal }} dh</td>
                    <td>{{ $totalCoutsGlobal }} dh</td>
                    <td>{{ $totalBeneficesGlobal }} dh</td>
                    <td>
                        @if($margeGlobale >= 20)
                            <span style="color: #90EE90; font-weight: bold;">{{ $margeGlobale }} %</span>
                        @elseif($margeGlobale >= 10)
                            <span style="color: #FFD700; font-weight: bold;">{{ $margeGlobale }} %</span>
                        @else
                            <span style="color: #FF6B6B; font-weight: bold;">{{ $margeGlobale }} %</span>
                        @endif
                    </td>
                    <td>-</td>
                </tr>
            </tbody>
        </table>
    @else
        <p style="color:#5B6573;">Aucun pôle commercial identifié pour le moment.</p>
    @endif

    {{-- Performance production --}}
    <h2>Performance production par pôle</h2>
    @if(in_array('production', $typesPoles))
        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Pôle</th>
                    <th>Quantité produite</th>
                    <th>Objectif de production</th>
                    <th>Taux d'atteinte (%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($labels as $index => $label)
                    @if($typesPoles[$index] === 'production')
                        <tr>
                            <td>{{ $label }}</td>
                            <td>{{ $totalProduction[$index] }}</td>
                            <td>{{ $totalObjectifs[$index] }}</td>
                            <td>
                                @if($tauxAtteinteProduction[$index] >= 100)
                                    <span style="color: green; font-weight: bold;">{{ $tauxAtteinteProduction[$index] }} %</span>
                                @elseif($tauxAtteinteProduction[$index] >= 75)
                                    <span style="color: orange; font-weight: bold;">{{ $tauxAtteinteProduction[$index] }} %</span>
                                @else
                                    <span style="color: red; font-weight: bold;">{{ $tauxAtteinteProduction[$index] }} %</span>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @else
        <p style="color:#5B6573;">Aucun pôle de production identifié pour le moment.</p>
    @endif

    {{-- Pôles sans indicateur quantitatif --}}
    @php $polesAutres = collect($labels)->filter(fn($l, $i) => $typesPoles[$i] === 'autre'); @endphp
    @if($polesAutres->count() > 0)
        <h2>Autres pôles</h2>
        <p style="color:#5B6573;">
            Aucun indicateur quantitatif (ventes ou production) n'est actuellement suivi pour :
            {{ $polesAutres->implode(', ') }}.
        </p>
    @endif

    {{-- Graphique Ventes / Bénéfices / Coûts --}}
    <h2>Ventes, coûts et bénéfices par pôle</h2>
   <div class="chart-box">
        <canvas id="chartVentes"></canvas>
    </div>

    {{-- Graphique Marges --}}
    <h2>Marge brute par pôle (%)</h2>
    <div class="chart-box">
        <canvas id="chartMarges"></canvas>
    </div>

    {{-- Graphique Production --}}
    <h2>Production par pôle</h2>
    <div class="chart-box">
        <canvas id="chartProduction"></canvas>
    </div>

    {{-- Graphique Objectifs --}}
    <h2>Objectifs par pôle</h2>
    <div class="chart-box">
        <canvas id="chartObjectifs"></canvas>
    </div>

    <h2>Taux d'atteinte des objectifs par pôle (%)</h2>
    <div class="chart-box">
        <canvas id="chartAtteinte"></canvas>
    </div>

    <h2>Évolution mensuelle des ventes</h2>
    <div class="chart-box">
        <canvas id="chartEvolution"></canvas>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>

<script>
const labels = @json($labels);

// Ventes
new Chart(document.getElementById('chartVentes'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Ventes',
                data: @json($totalVentes),
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            },
            {
                label: 'Coûts',
                data: @json($totalCouts),
                backgroundColor: 'rgba(255, 99, 132, 0.6)'
            },
            {
                label: 'Bénéfices',
                data: @json($totalBenefices),
                backgroundColor: 'rgba(75, 192, 192, 0.6)'
            }
        ]
    }
});

// Marges
new Chart(document.getElementById('chartMarges'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Marge brute (%)',
            data: @json($margesBrutes),
            backgroundColor: 'rgba(255, 99, 132, 0.6)'
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                max: 100,
                ticks: {
                    callback: value => value + '%'
                }
            }
        }
    }
});

// Production
new Chart(document.getElementById('chartProduction'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Quantité produite',
            data: @json($totalProduction),
            backgroundColor: 'rgba(255, 159, 64, 0.6)'
        }]
    }
});

// Objectifs
new Chart(document.getElementById('chartObjectifs'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Objectif cible',
            data: @json($totalObjectifs),
            backgroundColor: 'rgba(153, 102, 255, 0.6)'
        }]
    }
});

// Taux d'atteinte
new Chart(document.getElementById('chartAtteinte'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: "Taux d'atteinte des objectifs (%)",
            data: @json($tauxAtteinte),
            backgroundColor: 'rgba(54, 162, 235, 0.6)'
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                max: 150,
                ticks: {
                    callback: value => value + '%'
                }
            }
        }
    }
});

// Evolution mensuelle
new Chart(document.getElementById('chartEvolution'), {
    type: 'line',
    data: {
        labels: @json($moisLabels),
        datasets: [{
            label: 'Total des ventes',
            data: @json($moisTotaux),
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            tension: 0.3,
            fill: true
        }]
    }
});
</script>
@endsection