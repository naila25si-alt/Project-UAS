<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#14283b">
    <title>@yield('title', 'LabInvent Podcast')</title>
    <link rel="stylesheet" href="{{ asset('css/booking.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/facilities.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>
<body>
<div class="app-shell">
    <button class="sidebar-backdrop" type="button" aria-label="Tutup navigasi" data-sidebar-close></button>
    <aside class="sidebar" id="appSidebar">
        <a class="brand" href="{{ route('dashboard') }}">
            <span class="brand-mark" aria-hidden="true"><svg viewBox="0 0 40 40" fill="none"><path d="M7 16a18 18 0 0 1 26 0M12 21a11 11 0 0 1 16 0M17 26a4 4 0 0 1 6 0" stroke="currentColor" stroke-width="3" stroke-linecap="round"/><circle cx="20" cy="32" r="2" fill="currentColor"/></svg></span>
            <span class="brand-copy">LabInvent <b>Podcast</b></span>
        </a>

        <p class="nav-caption">MENU UTAMA</p>
        <nav class="sidebar-nav" aria-label="Navigasi utama">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="3" width="8" height="8" rx="2" stroke="currentColor" stroke-width="1.7"/><rect x="13" y="3" width="8" height="5" rx="2" stroke="currentColor" stroke-width="1.7"/><rect x="13" y="10" width="8" height="11" rx="2" stroke="currentColor" stroke-width="1.7"/><rect x="3" y="13" width="8" height="8" rx="2" stroke="currentColor" stroke-width="1.7"/></svg><span>Dashboard</span></a>
            <a href="{{ route('booking.index') }}" class="{{ request()->routeIs('booking.index', 'booking.store') ? 'active' : '' }}"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M16 3v4M8 3v4M3 10h18m-13 4h3m-3 4h7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg><span>Booking Studio</span></a>
            <a href="{{ route('booking.history') }}" class="{{ request()->routeIs('booking.history') ? 'active' : '' }}"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 7H1m3 0V4m0 3a9 9 0 1 1-1 7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/><path d="M12 7v5l3 2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg><span>Riwayat Booking</span></a>
            <a href="{{ route('studios.index') }}" class="{{ request()->routeIs('studios.*') ? 'active' : '' }}"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 10h1m4 0h1m-6 4h1m4 0h1m-5 7v-4h4v4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg><span>Studio</span></a>
            <a href="{{ route('equipment.index') }}" class="{{ request()->routeIs('equipment.*') ? 'active' : '' }}"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 7h16v13H4zM8 7V4h8v3m-8 5h8m-8 4h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg><span>Peralatan</span></a>
            <a href="{{ route('help.index') }}" class="{{ request()->routeIs('help.*') ? 'active' : '' }}"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/><path d="M9.5 9a2.6 2.6 0 1 1 4.4 1.9c-1.1 1-1.9 1.3-1.9 2.6m0 3h.01" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg><span>Pusat Bantuan</span></a>
        </nav>

        <div class="sidebar-promo">
            <span class="promo-kicker">SIAP REKAMAN?</span>
            <p>Temukan ruang yang pas untuk cerita berikutnya.</p>
            <a href="{{ route('booking.index') }}">Pesan studio <span aria-hidden="true">→</span></a>
        </div>
        <div class="sidebar-footer"><span class="online-dot"></span> Sistem reservasi aktif</div>
    </aside>

    <main class="main-area">
        <header class="topbar">
            <button class="mobile-menu-button" type="button" aria-label="Buka navigasi" aria-expanded="false" aria-controls="appSidebar" data-sidebar-toggle><span></span><span></span><span></span></button>
            <label class="global-search"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8" stroke="currentColor" stroke-width="1.8"/><path d="m16 16 4.5 4.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg><input id="pageSearch" type="search" placeholder="Cari di halaman ini..." aria-label="Cari di halaman ini"><kbd>/</kbd></label>
            <div class="topbar-right">
                <span class="topbar-date">{{ now()->translatedFormat('l, d F Y') }}</span>
                <span class="profile-avatar">{{ strtoupper(substr(auth()->user()?->name ?? 'T', 0, 1)) }}</span>
                <div class="profile-copy"><strong>{{ auth()->user()?->name ?? 'Tamu' }}</strong><small>{{ auth()->user()?->role === 'admin' ? 'Administrator' : (auth()->check() ? 'Mahasiswa' : 'Pengunjung') }}</small></div>
                @auth
                    <form method="POST" action="{{ route('logout') }}">@csrf<button class="logout-button" type="submit" title="Keluar" aria-label="Keluar"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M10 4H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h5m5-4 4-4-4-4m4 4H9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></button></form>
                @else
                    <a class="login-link" href="{{ route('login') }}">Masuk</a>
                @endauth
            </div>
        </header>
        <div class="content">
            @yield('content')
        </div>
    </main>
</div>
<script>
    const pageSearch = document.getElementById('pageSearch');
    const searchItems = [...document.querySelectorAll('[data-search-item]')];
    const searchEmpty = document.querySelector('[data-search-empty]');

    pageSearch?.addEventListener('input', () => {
        const query = pageSearch.value.trim().toLocaleLowerCase('id');
        let visibleItems = 0;

        searchItems.forEach((item) => {
            const matches = item.textContent.toLocaleLowerCase('id').includes(query);
            item.hidden = !matches;
            visibleItems += matches ? 1 : 0;
        });

        if (searchEmpty) {
            searchEmpty.hidden = query === '' || visibleItems > 0;
        }
    });

    pageSearch?.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            pageSearch.value = '';
            pageSearch.dispatchEvent(new Event('input'));
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === '/' && !['INPUT', 'TEXTAREA'].includes(document.activeElement.tagName)) {
            event.preventDefault();
            pageSearch?.focus();
        }
    });

    const sidebarToggle = document.querySelector('[data-sidebar-toggle]');
    const closeSidebar = () => {
        document.body.classList.remove('sidebar-open');
        sidebarToggle?.setAttribute('aria-expanded', 'false');
    };

    sidebarToggle?.addEventListener('click', () => {
        const isOpen = document.body.classList.toggle('sidebar-open');
        sidebarToggle.setAttribute('aria-expanded', String(isOpen));
    });
    document.querySelector('[data-sidebar-close]')?.addEventListener('click', closeSidebar);
    document.querySelectorAll('.sidebar-nav a').forEach((link) => link.addEventListener('click', closeSidebar));
</script>
</body>
</html>
