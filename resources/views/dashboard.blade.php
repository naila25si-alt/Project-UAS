<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - LabInvent: Podcast</title>
    <link rel="stylesheet" href="{{ asset('css/booking.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class="app-shell">
        <aside class="sidebar">
            <div class="brand">
                <span class="brand-mark">◉</span>
                <span>LabInvent: Podcast</span>
            </div>

            <nav>
                <a class="active" href="{{ route('dashboard') }}">⌂ <span>Dashboard</span></a>
                <a href="{{ route('booking.index') }}">▣ <span>Book a Studio</span></a>
                <a href="{{ route('booking.history') }}">▤ <span>My Bookings</span></a>

                <a href="{{ route('studios.index') }}"
                    class="sidebar-link {{ request()->routeIs('studios.*') ? 'active' : '' }}">
                    <span>▧</span>
                    <span>Studios</span>
                </a>

                <a href="{{ route('equipment.index') }}"
                    class="sidebar-link {{ request()->routeIs('equipment.*') ? 'active' : '' }}">
                    <span>⚙</span>
                    <span>Equipment</span>
                </a>

                <a href="{{ route('help.index') }}"
                    class="sidebar-link {{ request()->routeIs('help.*') ? 'active' : '' }}">
                    <span>ⓘ</span>
                    <span>Help</span>
                </a>
            </nav>

            <div class="sidebar-note">Podcast Studio Reservation</div>
        </aside>

        <main class="main-area">
            <header class="topbar">
                <div class="search">⌕ <span>Search</span></div>
                <div class="profile">
                    <span class="avatar">G</span>
                    <span>Guest User</span>
                    <span>⌄</span>
                </div>
            </header>

            <section class="content dashboard-content">
                <div class="dashboard-heading">
                    <div>
                        <p class="eyebrow">PODCAST STUDIO RESERVATION</p>
                        <h1>Dashboard</h1>
                        <p class="subheading">Selamat datang di LabInvent: Podcast Studio.</p>
                    </div>
                    <a class="btn btn-primary" href="{{ route('booking.index') }}">+ New Booking</a>
                </div>

                @if (session('success'))
                    <div class="alert success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert error">{{ session('error') }}</div>
                @endif

                <div class="dashboard-stats">
                    <article class="stat-card">
                        <div class="stat-icon blue">▤</div>
                        <div>
                            <span>Total Bookings</span>
                            <strong>{{ $totalBookings }}</strong>
                            <small>Semua pemesanan tersimpan</small>
                        </div>
                    </article>

                    <article class="stat-card">
                        <div class="stat-icon orange">◷</div>
                        <div>
                            <span>Pending Bookings</span>
                            <strong>{{ $pendingBookings }}</strong>
                            <small>Menunggu persetujuan</small>
                        </div>
                    </article>

                    <article class="stat-card">
                        <div class="stat-icon green">✓</div>
                        <div>
                            <span>Confirmed Bookings</span>
                            <strong>{{ $confirmedBookings }}</strong>
                            <small>Pemesanan dikonfirmasi</small>
                        </div>
                    </article>

                    <article class="stat-card">
                        <div class="stat-icon purple">▧</div>
                        <div>
                            <span>Active Studios</span>
                            <strong>{{ $totalStudios }}</strong>
                            <small>Studio tersedia di sistem</small>
                        </div>
                    </article>

                    <article class="stat-card">
                        <div class="stat-icon teal">⚙</div>
                        <div>
                            <span>Active Equipment</span>
                            <strong>{{ $totalEquipment }}</strong>
                            <small>Jenis equipment aktif</small>
                        </div>
                    </article>
                </div>

                <section class="dashboard-panel">
                    <div class="dashboard-panel-heading">
                        <div>
                            <h2>Recent Bookings</h2>
                            <p>Enam pemesanan terbaru yang masuk ke sistem.</p>
                        </div>
                        <a href="{{ route('booking.history') }}">View all bookings →</a>
                    </div>

                    <div class="dashboard-table-wrap">
                        <table class="dashboard-table">
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Customer</th>
                                    <th>Studio</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Participants</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentBookings as $booking)
                                    <tr>
                                        <td>#BK-{{ str_pad((string) $booking->id, 6, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $booking->customer_name }}</td>
                                        <td>{{ $booking->studio?->name ?? 'Studio dihapus' }}</td>
                                        <td>{{ $booking->start_date->format('d/m/Y') }}</td>
                                        <td>{{ substr($booking->start_time, 0, 5) }} -
                                            {{ substr($booking->end_time, 0, 5) }}</td>
                                        <td>{{ $booking->participants }} orang</td>
                                        <td>
                                            <span class="dashboard-status status-{{ strtolower($booking->status) }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="dashboard-empty">
                                            Belum ada pemesanan. Klik <strong>New Booking</strong> untuk membuat
                                            pemesanan pertama.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="dashboard-quick-actions">
                    <div>
                        <h2>Quick Actions</h2>
                        <p>Akses cepat ke fitur yang sudah tersedia.</p>
                    </div>
                    <div class="quick-action-links">
                        <a href="{{ route('booking.index') }}"><span>＋</span><b>Book a Studio</b><small>Buat pemesanan
                                baru</small></a>
                        <a href="{{ route('booking.history') }}"><span>▤</span><b>My Bookings</b><small>Lihat riwayat
                                pemesanan</small></a>
                    </div>
                </section>

                <footer>© {{ date('Y') }} LabInvent: Podcast Studio</footer>
            </section>
        </main>
    </div>
</body>

</html>
