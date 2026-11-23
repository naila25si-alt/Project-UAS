@extends('app')

@section('title', 'Dashboard Admin | LabInvent Podcast')

@section('content')
    <section class="dashboard-content admin-dashboard">
        <div class="dashboard-hero">
            <div class="hero-copy">
                <span class="eyebrow"><span class="eyebrow-dot"></span> ADMINISTRATOR · LABINVENT</span>
                <h1>Kelola studio<br><em>lebih mudah.</em></h1>
                <p>Pantau pemesanan, ruang, dan perlengkapan laboratorium dari satu tempat.</p>
                <a class="btn btn-primary hero-button" href="{{ route('booking.history') }}">Kelola booking <span aria-hidden="true">→</span></a>
            </div>
            <img src="{{ asset('images/studio-creator.svg') }}" alt="Ilustrasi studio produksi podcast" class="hero-image">
            <div class="hero-decoration" aria-hidden="true"></div>
        </div>

        <div class="dashboard-section-heading"><div><span class="section-overline">RINGKASAN SISTEM</span><h2>Operasional laboratorium</h2></div><span class="admin-live"><i></i> Sistem aktif</span></div>
        <div class="dashboard-stats">
            <article class="stat-card" data-search-item><span class="stat-icon blue"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M16 3v4M8 3v4M3 10h18m-13 4h3m-3 4h7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span><span class="stat-label">Semua booking</span><strong>{{ $totalBookings }}</strong><small>Seluruh pemesanan</small></article>
            <article class="stat-card" data-search-item><span class="stat-icon orange"><svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/><path d="M12 7v5l3 2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span><span class="stat-label">Perlu ditinjau</span><strong>{{ $pendingBookings }}</strong><small>Menunggu persetujuan</small></article>
            <article class="stat-card" data-search-item><span class="stat-icon green"><svg viewBox="0 0 24 24" fill="none"><path d="m5 12 4 4L19 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span><span class="stat-label">Terkonfirmasi</span><strong>{{ $confirmedBookings }}</strong><small>Booking disetujui</small></article>
            <article class="stat-card" data-search-item><span class="stat-icon purple"><svg viewBox="0 0 24 24" fill="none"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 10h1m4 0h1m-6 4h1m4 0h1m-5 7v-4h4v4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span><span class="stat-label">Studio aktif</span><strong>{{ $totalStudios }}</strong><small>Ruang operasional</small></article>
            <article class="stat-card" data-search-item><span class="stat-icon teal"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7h16v13H4zM8 7V4h8v3m-8 5h8m-8 4h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span><span class="stat-label">Peralatan aktif</span><strong>{{ $totalEquipment }}</strong><small>Jenis perlengkapan</small></article>
        </div>

        <section class="dashboard-panel">
            <div class="dashboard-panel-heading"><div><span class="section-overline">ANTRIAN TERBARU</span><h2>Booking masuk</h2><p>Tinjau jadwal terbaru dan status permintaan.</p></div><a class="text-link" href="{{ route('booking.history') }}">Buka semua booking <span aria-hidden="true">→</span></a></div>
            <div class="dashboard-table-wrap"><table class="dashboard-table"><thead><tr><th>Nomor</th><th>Pemesan</th><th>Studio</th><th>Tanggal</th><th>Waktu</th><th>Peserta</th><th>Status</th></tr></thead><tbody>
                @forelse ($recentBookings as $booking)
                    <tr data-search-item><td><strong class="booking-number">#BK-{{ str_pad((string) $booking->id, 5, '0', STR_PAD_LEFT) }}</strong></td><td>{{ $booking->customer_name }}<small class="admin-table-sub">{{ $booking->customer_email }}</small></td><td>{{ $booking->studio?->name ?? 'Studio dihapus' }}</td><td>{{ $booking->start_date->format('d M Y') }}</td><td>{{ substr($booking->start_time, 0, 5) }}–{{ substr($booking->end_time, 0, 5) }}</td><td>{{ $booking->participants }}</td><td><span class="dashboard-status status-{{ strtolower($booking->status) }}">{{ ucfirst($booking->status) }}</span></td></tr>
                @empty
                    <tr><td colspan="7" class="dashboard-empty">Belum ada booking yang masuk.</td></tr>
                @endforelse
            </tbody></table></div>
        </section>

        <section class="dashboard-quick-actions"><div><span class="section-overline">PENGELOLAAN</span><h2>Akses cepat admin</h2><p>Kelola informasi yang dibutuhkan pengguna.</p></div><div class="quick-action-links">
            <a href="{{ route('booking.history') }}"><span class="action-icon"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7H1m3 0V4m0 3a9 9 0 1 1-1 7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/><path d="M12 7v5l3 2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span><b>Riwayat booking</b><small>Tinjau semua permintaan</small><span class="action-arrow">→</span></a>
            <a href="{{ route('studios.index') }}"><span class="action-icon"><svg viewBox="0 0 24 24" fill="none"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 10h1m4 0h1m-6 4h1m4 0h1m-5 7v-4h4v4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span><b>Daftar studio</b><small>Periksa ruang aktif</small><span class="action-arrow">→</span></a>
            <a href="{{ route('equipment.index') }}"><span class="action-icon"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7h16v13H4zM8 7V4h8v3m-8 5h8m-8 4h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span><b>Inventaris alat</b><small>Periksa stok perlengkapan</small><span class="action-arrow">→</span></a>
        </div></section>
        <p class="page-footer">© {{ date('Y') }} LabInvent Podcast · Panel administrator</p>
    </section>
@endsection
