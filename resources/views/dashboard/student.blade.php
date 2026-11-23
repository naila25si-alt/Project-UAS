@extends('app')

@section('title', 'Dashboard Mahasiswa | LabInvent Podcast')

@section('content')
    <section class="dashboard-content student-dashboard">
        <div class="dashboard-hero student-hero">
            <div class="hero-copy">
                <span class="eyebrow"><span class="eyebrow-dot"></span> RUANG KREATIF KAMPUS</span>
                <h1>Halo, {{ Illuminate\Support\Str::before(auth()->user()->name, ' ') }}!<br><em>Siap mulai bercerita?</em></h1>
                <p>Pesan studio podcast kampus dan siapkan perlengkapan untuk sesi terbaikmu.</p>
                <a class="btn btn-primary hero-button" href="{{ route('booking.index') }}">Buat booking <span aria-hidden="true">→</span></a>
            </div>
            <img src="{{ asset('images/studio-cozy.svg') }}" alt="Ilustrasi studio podcast yang nyaman" class="hero-image">
            <div class="hero-decoration" aria-hidden="true"></div>
        </div>

        <div class="dashboard-section-heading"><div><span class="section-overline">AKUN SAYA</span><h2>Aktivitas booking kamu</h2></div><a class="text-link" href="{{ route('booking.history') }}">Riwayat saya <span aria-hidden="true">→</span></a></div>
        <div class="dashboard-stats student-stats">
            <article class="stat-card" data-search-item><span class="stat-icon blue"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M16 3v4M8 3v4M3 10h18m-13 4h3m-3 4h7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span><span class="stat-label">Booking saya</span><strong>{{ $totalBookings }}</strong><small>Total pemesanan kamu</small></article>
            <article class="stat-card" data-search-item><span class="stat-icon orange"><svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/><path d="M12 7v5l3 2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span><span class="stat-label">Menunggu</span><strong>{{ $pendingBookings }}</strong><small>Menunggu konfirmasi</small></article>
            <article class="stat-card" data-search-item><span class="stat-icon green"><svg viewBox="0 0 24 24" fill="none"><path d="m5 12 4 4L19 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span><span class="stat-label">Terkonfirmasi</span><strong>{{ $confirmedBookings }}</strong><small>Jadwal disetujui</small></article>
        </div>

        @if ($upcomingBooking)
            <section class="next-booking-card"><div class="next-booking-art"><img src="{{ asset('images/studio-aurora.svg') }}" alt="" loading="lazy"><span>BOOKING BERIKUTNYA</span></div><div class="next-booking-info"><span class="dashboard-status status-{{ strtolower($upcomingBooking->status) }}">{{ ucfirst($upcomingBooking->status) }}</span><h2>{{ $upcomingBooking->studio?->name ?? 'Studio dihapus' }}</h2><p>{{ $upcomingBooking->start_date->translatedFormat('l, d F Y') }}</p><div class="next-booking-meta"><span>{{ substr($upcomingBooking->start_time, 0, 5) }}–{{ substr($upcomingBooking->end_time, 0, 5) }}</span><span>{{ $upcomingBooking->participants }} peserta</span></div><a href="{{ route('booking.history') }}" class="text-link">Lihat detail booking →</a></div></section>
        @else
            <section class="student-empty-booking"><span class="empty-booking-icon"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M16 3v4M8 3v4M3 10h18m9 4h.01" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span><div><span class="section-overline">JADWAL BERIKUTNYA</span><h2>Belum ada sesi terjadwal</h2><p>Booking pertamamu siap dimulai kapan saja. Pilih studio dan waktu yang tersedia.</p></div><a class="btn btn-primary" href="{{ route('booking.index') }}">Pilih jadwal <span aria-hidden="true">→</span></a></section>
        @endif

        <section class="dashboard-panel student-recent-panel"><div class="dashboard-panel-heading"><div><span class="section-overline">RIWAYAT SAYA</span><h2>Booking terbaru</h2><p>Hanya pemesanan yang terhubung dengan email akunmu.</p></div><a class="text-link" href="{{ route('booking.history') }}">Semua booking <span aria-hidden="true">→</span></a></div><div class="dashboard-table-wrap"><table class="dashboard-table"><thead><tr><th>Studio</th><th>Tanggal</th><th>Waktu</th><th>Peserta</th><th>Status</th></tr></thead><tbody>
            @forelse ($recentBookings as $booking)
                <tr data-search-item><td><strong>{{ $booking->studio?->name ?? 'Studio dihapus' }}</strong><small class="admin-table-sub">#BK-{{ str_pad((string) $booking->id, 5, '0', STR_PAD_LEFT) }}</small></td><td>{{ $booking->start_date->format('d M Y') }}</td><td>{{ substr($booking->start_time, 0, 5) }}–{{ substr($booking->end_time, 0, 5) }}</td><td>{{ $booking->participants }} orang</td><td><span class="dashboard-status status-{{ strtolower($booking->status) }}">{{ ucfirst($booking->status) }}</span></td></tr>
            @empty
                <tr><td colspan="5" class="dashboard-empty">Booking yang kamu buat akan muncul di sini.</td></tr>
            @endforelse
        </tbody></table></div></section>

        <section class="student-feature-links"><a href="{{ route('studios.index') }}"><img src="{{ asset('images/studio-creator.svg') }}" alt="" loading="lazy"><span><small>JELAJAHI</small><strong>Studio podcast</strong><em>Lihat pilihan ruang →</em></span></a><a href="{{ route('equipment.index') }}"><img src="{{ asset('images/equipment-mixer.svg') }}" alt="" loading="lazy"><span><small>PERLENGKAPAN</small><strong>Peralatan studio</strong><em>Cek ketersediaan →</em></span></a></section>
        <p class="page-footer">© {{ date('Y') }} LabInvent Podcast · Dashboard mahasiswa</p>
    </section>
@endsection
