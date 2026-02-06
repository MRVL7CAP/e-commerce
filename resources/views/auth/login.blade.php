@extends('layout')

@section('title', 'Connexion')

@section('body')

<div class="min-h-screen flex items-center justify-center pb-60">
    <form class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4" method="POST" action="{{ route('login') }}" >
    @csrf

    <fieldset class="fieldset">
        <label class="label">Email</label>
        <input type="email" name="email" class="input validator" value="{{ old('email') }}" placeholder="Email" required />
        <p class="validator-hint hidden">Requis</p>
    </fieldset>

    <label class="fieldset">
        <span class="label">Password</span>
        <input id="password" type="password" name="password" class="input validator" placeholder="Password" required minlength="8" />
        <span id="password-hint" class="validator-hint hidden">Requis</span>
    </label>

    <button class="btn btn-neutral mt-4" type="submit">Login</button>
    <a href="{{ route('register') }}" class="btn btn-ghost mt-1">
        Créer un compte
    </a>
    </form>
</div>


<script>
  const password = document.getElementById('password');
  const hint = document.getElementById('password-hint');

  password.addEventListener('input', () => {
    const value = password.value;

    if (value.length === 0) {
      hint.textContent = 'Requis';
      hint.classList.remove('hidden');
    } else if (value.length < 8) {
      hint.textContent = 'Minimum 8 caractères';
      hint.classList.remove('hidden');
    } else {
      hint.classList.add('hidden');
    }
  });
</script>

@endsection
