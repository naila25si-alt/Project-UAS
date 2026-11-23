<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - LabInvent</title>
    <link rel="stylesheet" href="{{ asset('css/booking.css') }}">
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <div class="brand"><span class="brand-mark">◉</span><span>LabInvent: Podcast</span></div>
        <nav>
            <a href="{{ route('dashboard') }}">⌂ <span>Dashboard</span></a>
            <a href="{{ route('booking.index') }}">▣ <span>Book a Studio</span></a>
            <a class="active" href="{{ route('booking.history') }}">▤ <span>My Bookings</span></a>
        </nav>
    </aside>
    <main class="main-area">
        <header class="topbar"><div class="search">⌕ <span>Search</span></div><div class="profile">Guest User</div></header>
        <section class="content">
            <h1>My Bookings</h1>
            <p class="subheading">Daftar pemesanan yang tersimpan di database.</p>
            @if (session('success'))<div class="alert success">{{ session('success') }}</div>@endif
            <div class="panel table-wrap">
                <table>
                    <thead><tr><th>No.</th><th>Studio</th><th>Pemesan</th><th>Tanggal &amp; Waktu</th><th>Peserta</th><th>Status</th><th>Total</th></tr></thead>
                    <tbody>
                    @forelse ($bookings as $booking)
                        <tr>
                            <td>#{{ $booking->id }}</td>
                            <td>{{ $booking->studio->name }}</td>
                            <td>{{ $booking->customer_name }}</td>
                            <td>{{ $booking->start_date->format('d/m/Y') }} {{ substr($booking->start_time, 0, 5) }} – {{ $booking->end_date->format('d/m/Y') }} {{ substr($booking->end_time, 0, 5) }}</td>
                            <td>{{ $booking->participants }}</td>
                            <td><span class="status">{{ ucfirst($booking->status) }}</span></td>
                            <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="empty">Belum ada pemesanan.</td></tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $bookings->links() }}
            </div>
            <a class="btn btn-primary" href="{{ route('booking.index') }}">+ Buat Booking</a>
        </section>
    </main>
</div>
</body>
</html>
