@extends('layouts.app')

@section('title', 'Connexion - SmartPole')

@section('content')
    <h1>Connexion</h1>

    @if ($errors->any())
        <div style="color: red;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label for="email">Email :</label><br>
        <input type="email" name="email" id="email" value="{{ old('email') }}"><br><br>

        <label for="mot_de_passe">Mot de passe :</label><br>
        <input type="password" name="mot_de_passe" id="mot_de_passe"><br><br>

        <button type="submit">Se connecter</button>
    </form>
@endsection