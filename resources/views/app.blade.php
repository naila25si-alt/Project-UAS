<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'LabInvent : Podcast')</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
<div class="app">

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <div class="brand">
            <svg viewBox="0 0 48 30" width="22" height="14" fill="none" stroke="currentColor"
                 stroke-width="4" stroke-linecap="round" aria-hidden="true">
                <path d="M4 12a28 28 0 0 1 40 0"/><path d="M11 18a18 18 0 0 1 26 0"/><path d="M18 24a8 8 0 0 1 12 0"/>
            </svg>
            <span>LabInvent: Podcast</span>
        </div>

        <nav class="menu">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('booking.create') }}" class="{{ request()->routeIs('booking.*') ? 'active' : '' }}">Book a Studio</a>
            <a href="#">My Bookings</a>
            <a href="#">Studios</a>
            <a href="#">Equipment</a>
            <a href="#">Help</a>
        </nav>
    </aside>

    {{-- KONTEN UTAMA --}}
    <div class="main">
        <header class="topbar">
            <input type="search" class="search" placeholder="Search">

            <div class="user">
                <span class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <span>{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout">Logout</button>
                </form>
            </div>
        </header>

        <main class="content">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
