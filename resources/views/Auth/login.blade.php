<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | LabInvent : Podcast</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <main class="login-wrapper">
        <section class="login-card">

            {{-- Logo (ganti dengan <img src="{{ asset('images/logo-lip.png') }}"> jika sudah ada file logo) --}}
            <div class="logo">
                <svg viewBox="0 0 48 30" width="44" height="28" fill="none" stroke="currentColor"
                     stroke-width="3.5" stroke-linecap="round" aria-hidden="true">
                    <path d="M4 12a28 28 0 0 1 40 0"/>
                    <path d="M11 18a18 18 0 0 1 26 0"/>
                    <path d="M18 24a8 8 0 0 1 12 0"/>
                </svg>
                <span class="logo-text">LIP</span>
            </div>

            <h1 class="app-title">LabInvent : Podcast</h1>

            @if ($errors->any())
                <div class="alert" role="alert">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <label for="login">NIM/Email</label>
                <input type="text" id="login" name="login" value="{{ old('login') }}"
                       autocomplete="username" required autofocus>

                <label for="password">Password</label>
                <input type="password" id="password" name="password"
                       autocomplete="current-password" required>

                <button type="submit" class="btn-login">Login</button>
            </form>

            <div class="links">
                <a href="{{ route('password.request') }}">Forgot Password?</a>
                <a href="{{ route('contact.admin') }}">Contact Admin</a>
            </div>
        </section>
    </main>
</body>
</html>
