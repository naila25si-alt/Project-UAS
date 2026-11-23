<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Booking - Podcast Studio</title>
    <link rel="stylesheet" href="{{ asset('css/booking.css') }}">
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <div class="brand"><span class="brand-mark">◉</span><span>LabInvent: Podcast</span></div>
        <nav>
            <a href="{{ route('dashboard') }}">⌂ <span>Dashboard</span></a>
            <a class="active" href="{{ route('booking.index') }}">▣ <span>Book a Studio</span></a>
            <a href="{{ route('booking.history') }}">▤ <span>My Bookings</span></a>
            <a href="{{ route('booking.index') }}">▧ <span>Studios</span></a>
            <a href="{{ route('booking.index') }}">⚙ <span>Equipment</span></a>
            <a href="{{ route('booking.index') }}">ⓘ <span>Help</span></a>
        </nav>
        <div class="sidebar-note">Podcast Studio Reservation</div>
    </aside>

    <main class="main-area">
        <header class="topbar">
            <div class="search">⌕ <span>Search</span></div>
            <div class="profile"><span class="avatar">G</span><span>Guest User</span><span>⌄</span></div>
        </header>

        <section class="content">
            <div class="page-heading">
                <div>
                    <p class="eyebrow">PODCAST STUDIO RESERVATION</p>
                    <h1>New Booking - Podcast Studio</h1>
                    <p class="subheading">Pilih studio dan lengkapi detail pemesanan kamu.</p>
                </div>
                <span class="step-pill">Step 1 of 2</span>
            </div>

            @if (session('success'))
                <div class="alert success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert error">
                    <strong>Periksa kembali data kamu:</strong>
                    <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
                @csrf

                <section class="panel">
                    <div class="section-title"><span class="number">1.</span><div><h2>Select a Studio</h2><p>Pilih satu studio yang sesuai kebutuhan.</p></div></div>
                    <div class="studio-grid">
                        @forelse ($studios as $studio)
                            <label class="studio-card">
                                <input type="radio" name="studio_id" value="{{ $studio->id }}"
                                    data-capacity="{{ $studio->capacity }}"
                                    data-price="{{ $studio->price_per_hour }}"
                                    {{ (string) old('studio_id') === (string) $studio->id || (!$errors->any() && $loop->first) ? 'checked' : '' }} required>
                                <div class="studio-image" style="background-color: {{ $studio->color }}">
                                    @if ($studio->image)
                                        <img src="{{ $studio->image }}" alt="{{ $studio->name }}" onerror="this.style.display='none'">
                                    @else
                                        <span>Podcast Studio</span>
                                    @endif
                                </div>
                                <div class="studio-info">
                                    <strong>{{ $studio->name }}</strong>
                                    <small>{{ $studio->subtitle }}</small>
                                    <p>{{ $studio->features }}</p>
                                    <div class="studio-meta"><span>♙ Max {{ $studio->capacity }} people</span><b>Rp {{ number_format($studio->price_per_hour, 0, ',', '.') }}/jam</b></div>
                                </div>
                            </label>
                        @empty
                            <p>Data studio belum tersedia. Jalankan seeder terlebih dahulu.</p>
                        @endforelse
                    </div>
                </section>

                <section class="panel">
                    <div class="section-title"><span class="number">2.</span><div><h2>Date &amp; Time</h2><p>Tentukan waktu mulai dan selesai.</p></div></div>
                    <div class="form-grid four">
                        <label>Start Date<input type="date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required></label>
                        <label>Start Time<input type="time" name="start_time" value="{{ old('start_time', '09:00') }}" required></label>
                        <label>End Date<input type="date" name="end_date" value="{{ old('end_date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required></label>
                        <label>End Time<input type="time" name="end_time" value="{{ old('end_time', '11:00') }}" required></label>
                    </div>
                </section>

                <section class="panel">
                    <div class="section-title"><span class="number">3.</span><div><h2>Booking Details</h2><p>Masukkan informasi pemesan dan kebutuhan acara.</p></div></div>
                    <div class="form-grid two">
                        <label>Full Name<input type="text" name="customer_name" value="{{ old('customer_name') }}" placeholder="Nama pemesan" maxlength="120" required></label>
                        <label>Email (optional)<input type="email" name="customer_email" value="{{ old('customer_email') }}" placeholder="nama@email.com"></label>
                    </div>
                    <label class="full-label">Purpose / Description<textarea name="purpose" rows="3" placeholder="Contoh: Interview, podcast edukasi, dan lain-lain">{{ old('purpose') }}</textarea></label>
                    <label class="participant-label">Number of Participants
                        <input type="number" name="participants" id="participants" min="1" max="100" value="{{ old('participants', 2) }}" required>
                        <small id="capacityHint">Pilih studio untuk melihat kapasitas maksimum.</small>
                    </label>
                </section>

                <section class="panel">
                    <div class="section-title"><span class="number">4.</span><div><h2>Equipment</h2><p>Pilih peralatan tambahan yang diperlukan.</p></div></div>
                    <div class="equipment-grid">
                        @forelse ($equipment as $item)
                            <label class="equipment-option">
                                <input type="checkbox" name="equipment[]" value="{{ $item->id }}" {{ in_array($item->id, old('equipment', [])) ? 'checked' : '' }}>
                                <span>{{ $item->name }}</span>
                                <small>Stok: {{ $item->stock }}</small>
                            </label>
                        @empty
                            <p>Belum ada data equipment.</p>
                        @endforelse
                    </div>
                </section>

                <div class="form-actions">
                    <a class="btn btn-light" href="{{ route('dashboard') }}">Back</a>
                    <button class="btn btn-primary" type="submit">Review &amp; Submit Booking →</button>
                </div>
            </form>
            <footer>© {{ date('Y') }} LabInvent: Podcast Studio · Booking preview</footer>
        </section>
    </main>
</div>

<script>
    const studioRadios = document.querySelectorAll('input[name="studio_id"]');
    const participants = document.getElementById('participants');
    const capacityHint = document.getElementById('capacityHint');

    function updateCapacity() {
        const selected = document.querySelector('input[name="studio_id"]:checked');
        if (!selected) return;
        const capacity = Number(selected.dataset.capacity);
        participants.max = capacity;
        capacityHint.textContent = `Kapasitas studio ini maksimal ${capacity} orang.`;
        if (Number(participants.value) > capacity) participants.value = capacity;
    }
    studioRadios.forEach(radio => radio.addEventListener('change', updateCapacity));
    updateCapacity();

    document.querySelector('input[name="start_date"]').addEventListener('change', event => {
        document.querySelector('input[name="end_date"]').min = event.target.value;
    });
</script>
</body>
</html>
