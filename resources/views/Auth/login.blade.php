<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f4f7fb">
    <title>Masuk | LabInvent Podcast</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <main class="login-shell">
        <section class="welcome-panel" aria-label="Informasi LabInvent Podcast">
            <a class="brand" href="{{ url('/') }}" aria-label="LabInvent Podcast">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 40 40" fill="none"><path d="M7 16a18 18 0 0 1 26 0M12 21a11 11 0 0 1 16 0M17 26a4 4 0 0 1 6 0" stroke="currentColor" stroke-width="3" stroke-linecap="round"/><circle cx="20" cy="32" r="2" fill="currentColor"/></svg>
                </span>
                <span>LabInvent <b>Podcast</b></span>
            </a>

            <div class="welcome-copy">
                <span class="eyebrow"><span></span> LABORATORIUM INFORMATIKA</span>
                <h1>Ruang untuk<br>ide yang <em>terdengar.</em></h1>
                <p>Kelola studio podcast dan peralatan laboratorium dengan mudah dalam satu tempat.</p>
            </div>

            <div class="studio-card" aria-hidden="true">
                <div class="studio-top"><span class="live-dot"></span><span>STUDIO SESSION</span><span class="studio-time">00:24:18</span></div>
                <div class="waveform"><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></div>
                <div class="studio-bottom"><span>Podcast Studio A</span><span>●&nbsp; Siap digunakan</span></div>
            </div>
            <div class="panel-footer"><span>© {{ date('Y') }} LabInvent</span><span>Universitas · Laboratorium Informatika</span></div>
        </section>

        <section class="form-panel" aria-labelledby="login-title">
            <div class="form-inner">
                <div class="mobile-brand brand">
                    <span class="brand-mark" aria-hidden="true"><svg viewBox="0 0 40 40" fill="none"><path d="M7 16a18 18 0 0 1 26 0M12 21a11 11 0 0 1 16 0M17 26a4 4 0 0 1 6 0" stroke="currentColor" stroke-width="3" stroke-linecap="round"/><circle cx="20" cy="32" r="2" fill="currentColor"/></svg></span>
                    <span>LabInvent <b>Podcast</b></span>
                </div>
                <div class="form-heading">
                    <span class="heading-kicker">SELAMAT DATANG KEMBALI</span>
                    <h2 id="login-title">Masuk ke akunmu</h2>
                    <p>Pilih jenis akun, lalu masukkan detail untuk melanjutkan.</p>
                </div>

                @if ($errors->any())
                    <div class="alert" role="alert"><span aria-hidden="true">!</span>{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('login.store') }}" class="login-form">
                    @csrf
                    <fieldset class="role-fieldset">
                        <legend>Masuk sebagai</legend>
                        <div class="role-options">
                            <label class="role-option">
                                <input type="radio" name="role" value="mahasiswa" {{ old('role', 'mahasiswa') === 'mahasiswa' ? 'checked' : '' }}>
                                <span class="role-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3 2.5 8 12 13l9.5-5L12 3Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M6.5 10.2v5.1c3.2 2.7 7.8 2.7 11 0v-5.1M21.5 8v6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span>
                                <span class="role-text"><strong>Mahasiswa</strong><small>Masuk dengan NIM atau email</small></span>
                                <span class="radio-dot"></span>
                            </label>
                            <label class="role-option">
                                <input type="radio" name="role" value="admin" {{ old('role') === 'admin' ? 'checked' : '' }}>
                                <span class="role-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3 19 6v5c0 4.6-3 8-7 10-4-2-7-5.4-7-10V6l7-3Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="m9 12 2 2 4-4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                <span class="role-text"><strong>Admin</strong><small>Masuk dengan email admin</small></span>
                                <span class="radio-dot"></span>
                            </label>
                        </div>
                    </fieldset>

                    <div class="field-group">
                        <label for="login" id="login-label">NIM atau email</label>
                        <div class="input-wrap"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.7"/><path d="M4 20c.6-3.4 3.8-5.5 8-5.5s7.4 2.1 8 5.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                            <input type="text" id="login" name="login" value="{{ old('login') }}" placeholder="Contoh: 20230001 atau nama@email.com" autocomplete="username" required autofocus>
                        </div>
                    </div>
                    <div class="field-group">
                        <div class="label-row"><label for="password">Password</label></div>
                        <div class="input-wrap"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="4" y="10" width="16" height="11" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 10V7a4 4 0 1 1 8 0v3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/><circle cx="12" cy="15" r="1" fill="currentColor"/></svg>
                            <input type="password" id="password" name="password" placeholder="Masukkan password" autocomplete="current-password" required>
                            <button class="password-toggle" type="button" aria-label="Tampilkan password" aria-pressed="false"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M2.5 12s3.3-6 9.5-6 9.5 6 9.5 6-3.3 6-9.5 6-9.5-6-9.5-6Z" stroke="currentColor" stroke-width="1.7"/><circle cx="12" cy="12" r="2.5" stroke="currentColor" stroke-width="1.7"/></svg></button>
                        </div>
                    </div>
                    <div class="form-extras"><label class="remember"><input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}><span class="checkmark"></span>Ingat saya</label></div>
                    <button class="submit-button" type="submit">Masuk <span aria-hidden="true">→</span></button>
                </form>

                <p class="help-text">Butuh bantuan masuk? <a href="{{ route('help.index') }}">Hubungi pengelola</a></p>
                <div class="security-note"><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M10 2.5 16 5v4.3c0 3.8-2.5 6.7-6 8.2-3.5-1.5-6-4.4-6-8.2V5l6-2.5Z" stroke="currentColor" stroke-width="1.4"/><path d="m7.5 10 1.7 1.7 3.5-3.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Login aman untuk sivitas akademika</div>
            </div>
        </section>
    </main>
    <script>
        const roleInputs = document.querySelectorAll('input[name="role"]');
        const loginInput = document.getElementById('login');
        const loginLabel = document.getElementById('login-label');
        const syncLoginField = () => {
            const admin = document.querySelector('input[name="role"]:checked')?.value === 'admin';
            loginLabel.textContent = admin ? 'Email admin' : 'NIM atau email';
            loginInput.placeholder = admin ? 'nama@email.com' : 'Contoh: 20230001 atau nama@email.com';
            loginInput.autocomplete = admin ? 'username' : 'username';
        };
        roleInputs.forEach((input) => input.addEventListener('change', syncLoginField));
        syncLoginField();

        const passwordToggle = document.querySelector('.password-toggle');
        passwordToggle.addEventListener('click', () => {
            const password = document.getElementById('password');
            const visible = password.type === 'password';
            password.type = visible ? 'text' : 'password';
            passwordToggle.setAttribute('aria-pressed', String(visible));
            passwordToggle.setAttribute('aria-label', visible ? 'Sembunyikan password' : 'Tampilkan password');
        });
    </script>
</body>
</html>
