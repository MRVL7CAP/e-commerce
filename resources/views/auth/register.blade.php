@extends('layout')

@section('title', 'Inscription')

@section('body')

<div class="min-h-screen flex items-center justify-center pb-60">
    <form class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4" method="POST" action="{{ route('register') }}" >
    @csrf

    <fieldset class="fieldset">
        <label class="label">Nom</label>
        <input name="name" class="input validator" value="{{ old('name') }}" placeholder="Nom" required />
        <p class="validator-hint hidden">Requis</p>
    </fieldset>

    <fieldset class="fieldset">
        <label class="label">Email</label>
        <input type="email" name="email" class="input validator" value="{{ old('email') }}" placeholder="Email" required />
        <p class="validator-hint hidden">Requis</p>
    </fieldset>

    <label class="fieldset">
        <span class="label">Mot de passe</span>
        <input type="password" name="password" class="input validator" placeholder="Mot de passe" required />
        <span class="validator-hint hidden">Requis</span>
    </label>

    <button class="btn btn-neutral mt-4" type="submit">Créer mon compte</button>
    <a href="{{ route('login') }}" class="btn btn-ghost mt-1">
        Se connecter
    </a>
    </form>
</div>

@endsection
