<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cline x1='15' y1='15' x2='15' y2='4' stroke='%2316324F' stroke-width='2'/%3E%3Cline x1='15' y1='15' x2='25' y2='20' stroke='%2316324F' stroke-width='2'/%3E%3Cline x1='15' y1='15' x2='5' y2='20' stroke='%2316324F' stroke-width='2'/%3E%3Ccircle cx='15' cy='4' r='3' fill='%23E3A008'/%3E%3Ccircle cx='25' cy='20' r='3' fill='%23E3A008'/%3E%3Ccircle cx='5' cy='20' r='3' fill='%23E3A008'/%3E%3Ccircle cx='15' cy='15' r='4.5' fill='%2316324F'/%3E%3C/svg%3E">
    <title>@yield('title', 'SmartPole')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <header class="navbar">
        <div class="navbar-inner">
            <a href="{{ url('/') }}" class="navbar-brand">
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <line x1="15" y1="15" x2="15" y2="4" stroke="#16324F" stroke-width="2"/>
                    <line x1="15" y1="15" x2="25" y2="20" stroke="#16324F" stroke-width="2"/>
                    <line x1="15" y1="15" x2="5" y2="20" stroke="#16324F" stroke-width="2"/>
                    <circle cx="15" cy="4" r="3" fill="#E3A008"/>
                    <circle cx="25" cy="20" r="3" fill="#E3A008"/>
                    <circle cx="5" cy="20" r="3" fill="#E3A008"/>
                    <circle cx="15" cy="15" r="4.5" fill="#16324F"/>
                </svg>
         <span class="navbar-wordmark">SmartPole</span>
            </a>

            @auth
                <nav class="navbar-links">
                    <a href="{{ route('dashboard') }}">Tableau de bord</a>

                    @if(in_array(Auth::user()->role, ['administrateur', 'direction']))
                        <a href="{{ route('poles.index') }}">Pôles</a>
                    @endif

                    @if(Auth::user()->role == 'administrateur')
                        <a href="{{ route('utilisateurs.index') }}">Utilisateurs</a>
                    @endif

                    <a href="{{ route('ventes.index') }}">Ventes</a>
                    <a href="{{ route('objectifs.index') }}">Objectifs</a>
                    <a href="{{ route('production.index') }}">Production</a>
                    <a href="{{ route('rapports.index') }}">Rapports</a>
                    <a href="{{ route('predictions.index') }}">Prédictions IA</a>
                </nav>

                <div class="navbar-user">
                    <a href="{{ route('profil') }}" class="navbar-username">{{ Auth::user()->nom }}</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-logout">Déconnexion</button>
                    </form>
                </div>
            @endauth

            @guest
    		@unless(request()->routeIs('login'))
        	<a href="{{ route('login') }}" class="navbar-cta">Se connecter</a>
    		@endunless
@endguest
        </div>
    </header>

    <main class="container">
        @yield('content')
    </main>
</body>
</html>