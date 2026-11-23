@extends('app')

@section('title', 'Pilihan Studio | LabInvent Podcast')

@section('content')
    <section class="facilities-page">
        <div class="facility-hero"><div><span class="eyebrow">RUANG UNTUK SETIAP CERITA</span><h1>Pilih studio<br>favoritmu.</h1><p>Temukan suasana yang tepat untuk rekaman podcast, wawancara, maupun produksi konten.</p><a class="btn btn-primary" href="{{ route('booking.index') }}">Pesan studio <span aria-hidden="true">→</span></a></div><img src="{{ asset('images/studio-cozy.svg') }}" alt="Ilustrasi studio podcast hangat" loading="lazy"></div>
        <div class="facility-section-heading"><div><span class="section-overline">RUANG TERSEDIA</span><h2>Studio aktif <span class="result-count">{{ $studios->count() }}</span></h2></div><p>Pilih tombol pesan untuk menentukan tanggal dan jam penggunaan.</p></div>
        <div class="facility-grid">
            @php($studioImages = ['images/studio-aurora.svg', 'images/studio-cozy.svg', 'images/studio-creator.svg'])
            @forelse ($studios as $studio)
                <article class="facility-card" data-search-item>
                    <div class="facility-image-wrap"><img src="{{ asset($studioImages[$loop->index] ?? 'images/studio-creator.svg') }}" class="facility-image" alt="Ilustrasi {{ $studio->name }}" loading="lazy"><span class="facility-tag">{{ $studio->capacity }} PESERTA</span></div>
                    <div class="card-content"><div class="card-heading"><div><h3>{{ $studio->name }}</h3><span>{{ $studio->subtitle }}</span></div><span class="availability-dot" title="Aktif"></span></div><p>{{ $studio->description }}</p><div class="feature-chips">@foreach (array_slice(explode(',', $studio->features ?? 'Studio podcast'), 0, 3) as $feature)<span>{{ trim($feature) }}</span>@endforeach</div><div class="card-footer"><span class="price-label">Mulai dari<strong>Rp {{ number_format($studio->price_per_hour, 0, ',', '.') }}<small>/jam</small></strong></span><a href="{{ route('booking.index') }}" class="book-button">Pilih studio <span aria-hidden="true">→</span></a></div></div>
                </article>
            @empty
                <div class="empty-state"><strong>Belum ada studio aktif.</strong><span>Silakan hubungi pengelola untuk informasi jadwal studio.</span></div>
            @endforelse
        </div>
        <p class="search-empty" data-search-empty hidden>Studio tidak ditemukan. Coba kata pencarian lain.</p>
        <p class="page-footer">© {{ date('Y') }} LabInvent Podcast</p>
    </section>
@endsection
