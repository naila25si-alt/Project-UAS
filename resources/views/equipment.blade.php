@extends('app')

@section('title', 'Peralatan Studio | LabInvent Podcast')

@section('content')
    <section class="facilities-page equipment-page">
        <div class="facility-hero equipment-hero"><div><span class="eyebrow">PERLENGKAPAN PRODUKSI</span><h1>Suara dan gambar<br>yang lebih baik.</h1><p>Kenali perangkat yang tersedia dan tambahkan ke booking studio kamu.</p><a class="btn btn-primary" href="{{ route('booking.index') }}">Mulai booking <span aria-hidden="true">→</span></a></div><img src="{{ asset('images/equipment-mixer.svg') }}" alt="Ilustrasi mixer audio podcast" loading="lazy"></div>
        <div class="facility-section-heading"><div><span class="section-overline">INVENTARIS</span><h2>Peralatan aktif <span class="result-count">{{ $equipment->count() }}</span></h2></div><p>Stok ditampilkan sebagai informasi ketersediaan untuk sesi.</p></div>
        <div class="equipment-catalog">
            @php($equipmentImages = ['headphones' => 'equipment-headphones.svg', 'audio mixer' => 'equipment-mixer.svg', 'condenser microphone' => 'equipment-microphone.svg', 'camera' => 'equipment-camera.svg', 'tripod' => 'equipment-tripod.svg', 'ring light' => 'equipment-ringlight.svg'])
            @forelse ($equipment as $item)
                @php($equipmentImage = $equipmentImages[strtolower($item->name)] ?? 'equipment-microphone.svg')
                <article class="catalog-card" data-search-item><img src="{{ asset('images/'.$equipmentImage) }}" alt="Ilustrasi {{ $item->name }}" loading="lazy"><div class="catalog-info"><span class="catalog-category">PERLENGKAPAN PODCAST</span><h3>{{ $item->name }}</h3><p>{{ $item->description }}</p><div class="catalog-stock"><span><i class="stock-indicator {{ $item->stock > 0 ? 'in-stock' : 'out-stock' }}"></i>{{ $item->stock > 0 ? 'Tersedia' : 'Stok habis' }}</span><strong>{{ $item->stock }} unit</strong></div><a href="{{ route('booking.index') }}" class="catalog-link">Tambahkan saat booking <span aria-hidden="true">→</span></a></div></article>
            @empty
                <div class="empty-state"><strong>Belum ada peralatan aktif.</strong><span>Silakan tanyakan ketersediaan kepada pengelola studio.</span></div>
            @endforelse
        </div>
        <p class="search-empty" data-search-empty hidden>Peralatan tidak ditemukan. Coba kata pencarian lain.</p>
        <p class="page-footer">© {{ date('Y') }} LabInvent Podcast</p>
    </section>
@endsection
