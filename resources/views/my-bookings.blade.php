@extends('app')

@section('title', 'Riwayat Booking | LabInvent Podcast')

@section('content')
    <section class="history-page">
        <div class="page-heading"><div><span class="eyebrow">AKTIVITAS RESERVASI</span><h1>Riwayat booking</h1><p class="subheading">Semua pemesanan studio yang telah tersimpan.</p></div><a class="btn btn-primary" href="{{ route('booking.index') }}">+ Booking baru</a></div>
        @if (session('success'))<div class="alert success" role="status">{{ session('success') }}</div>@endif
        <div class="history-summary"><span class="history-summary-icon"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7H1m3 0V4m0 3a9 9 0 1 1-1 7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/><path d="M12 7v5l3 2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span><div><strong>{{ $bookings->total() }} booking</strong><small>Gunakan pencarian di atas untuk menemukan pemesan atau studio.</small></div></div>
        <section class="panel history-panel">
            <div class="dashboard-table-wrap">
                <table class="history-table">
                    <thead><tr><th>Booking</th><th>Studio &amp; Peralatan</th><th>Pemesan</th><th>Jadwal</th><th>Peserta</th><th>Status</th><th>Estimasi</th>@if (auth()->user()->role === 'admin')<th>Aksi admin</th>@endif</tr></thead>
                    <tbody>
                    @forelse ($bookings as $booking)
                        <tr data-search-item>
                            <td><strong class="booking-number">#BK-{{ str_pad((string) $booking->id, 5, '0', STR_PAD_LEFT) }}</strong><small class="muted-cell">Dibuat {{ $booking->created_at->format('d M Y') }}</small></td>
                            <td><strong>{{ $booking->studio?->name ?? 'Studio dihapus' }}</strong><small class="muted-cell">{{ $booking->equipment->pluck('name')->join(', ') ?: 'Tanpa peralatan tambahan' }}</small></td>
                            <td>{{ $booking->customer_name }}<small class="muted-cell">{{ $booking->customer_email ?: 'Email tidak disertakan' }}</small></td>
                            <td>{{ $booking->start_date->format('d M Y') }}<small class="muted-cell">{{ substr($booking->start_time, 0, 5) }}–{{ substr($booking->end_time, 0, 5) }}{{ $booking->end_date->isSameDay($booking->start_date) ? '' : ' · '.$booking->end_date->format('d M') }}</small></td>
                            <td>{{ $booking->participants }} orang</td>
                            <td><span class="dashboard-status status-{{ strtolower($booking->status) }}">{{ match ($booking->status) { 'pending' => 'Menunggu', 'confirmed' => 'Disetujui', 'cancelled', 'canceled' => 'Dibatalkan', default => ucfirst($booking->status) } }}</span></td>
                            <td><strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong></td>
                            @if (auth()->user()->role === 'admin')
                                <td>
                                    <form class="status-action-form" action="{{ route('admin.bookings.status', $booking) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <label class="visually-hidden" for="status-{{ $booking->id }}">Status booking #{{ $booking->id }}</label>
                                        <select id="status-{{ $booking->id }}" name="status" aria-label="Status booking #{{ $booking->id }}">
                                            <option value="pending" @selected($booking->status === 'pending')>Menunggu</option>
                                            <option value="confirmed" @selected($booking->status === 'confirmed')>Disetujui</option>
                                            <option value="cancelled" @selected(in_array($booking->status, ['cancelled', 'canceled']))>Dibatalkan</option>
                                        </select>
                                        <button type="submit">Simpan</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr><td colspan="{{ auth()->user()->role === 'admin' ? 8 : 7 }}" class="dashboard-empty">Belum ada booking. Pesan studio untuk melihatnya di sini.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <p class="search-empty" data-search-empty hidden>Tidak ada booking yang cocok dengan pencarian.</p>
            <div class="pagination-wrap">{{ $bookings->links() }}</div>
        </section>
        <p class="page-footer">© {{ date('Y') }} LabInvent Podcast</p>
    </section>
@endsection
