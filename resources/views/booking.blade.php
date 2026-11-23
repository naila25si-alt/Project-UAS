@extends('app')

@section('title', 'Booking Studio | LabInvent Podcast')

@section('content')
    <section class="booking-page">
        <div class="page-heading">
            <div><span class="eyebrow">RESERVASI STUDIO</span><h1>Rencanakan sesi podcast</h1><p class="subheading">Pilih ruang, atur jadwal, dan siapkan perlengkapan yang kamu perlukan.</p></div>
            <span class="step-pill"><span>01</span> Detail booking</span>
        </div>

        @if (session('success'))<div class="alert success" role="status">{{ session('success') }} <a href="{{ route('booking.history') }}">Lihat riwayat →</a></div>@endif
        @if ($errors->any())
            <div class="alert error" role="alert"><strong>Booking belum dapat disimpan.</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
            @csrf
            <section class="panel booking-panel">
                <div class="section-title"><span class="section-number">01</span><div><h2>Pilih studio</h2><p>Pilih ruangan sesuai suasana dan jumlah peserta.</p></div></div>
                <div class="studio-grid booking-studio-grid">
                    @php($studioImages = ['images/studio-aurora.svg', 'images/studio-cozy.svg', 'images/studio-creator.svg'])
                    @forelse ($studios as $studio)
                        <label class="studio-card" data-search-item>
                            <input type="radio" name="studio_id" value="{{ $studio->id }}" data-capacity="{{ $studio->capacity }}" data-price="{{ $studio->price_per_hour }}" {{ (string) old('studio_id') === (string) $studio->id || (!$errors->any() && $loop->first) ? 'checked' : '' }} required>
                            <div class="studio-image"><img src="{{ asset($studioImages[$loop->index] ?? 'images/studio-creator.svg') }}" alt="Ilustrasi {{ $studio->name }}" loading="lazy"><span class="image-badge">STUDIO {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span></div>
                            <div class="studio-info"><strong>{{ $studio->name }}</strong><small>{{ $studio->subtitle }}</small><p>{{ $studio->description }}</p><div class="studio-meta"><span>Hingga {{ $studio->capacity }} orang</span><b>Rp {{ number_format($studio->price_per_hour, 0, ',', '.') }}<small>/jam</small></b></div></div>
                        </label>
                    @empty
                        <div class="empty-state"><strong>Belum ada studio aktif.</strong><span>Tambahkan data studio sebelum membuat booking.</span></div>
                    @endforelse
                </div>
                <p class="search-empty" data-search-empty hidden>Tak ada studio atau peralatan yang cocok dengan pencarian.</p>
            </section>

            <section class="panel booking-panel">
                <div class="section-title"><span class="section-number">02</span><div><h2>Tanggal dan waktu</h2><p>Pemesanan dihitung per jam dan jadwal studio tidak boleh bertabrakan.</p></div></div>
                <div class="form-grid four">
                    @php($defaultStart = now()->addHour()->startOfHour())
                    @php($defaultEnd = $defaultStart->copy()->addHours(2))
                    <label>Tanggal mulai<input type="date" name="start_date" value="{{ old('start_date', $defaultStart->toDateString()) }}" min="{{ date('Y-m-d') }}" required></label>
                    <label>Jam mulai<input type="time" name="start_time" value="{{ old('start_time', $defaultStart->format('H:i')) }}" required></label>
                    <label>Tanggal selesai<input type="date" name="end_date" value="{{ old('end_date', $defaultEnd->toDateString()) }}" min="{{ old('start_date', $defaultStart->toDateString()) }}" required></label>
                    <label>Jam selesai<input type="time" name="end_time" value="{{ old('end_time', $defaultEnd->format('H:i')) }}" required></label>
                </div>
            </section>

            <section class="panel booking-panel">
                <div class="section-title"><span class="section-number">03</span><div><h2>Informasi pemesan</h2><p>Isi detail agar pengelola dapat menghubungi kamu.</p></div></div>
                <div class="form-grid two">
                    <label>Nama lengkap<input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()?->name) }}" placeholder="Nama pemesan" maxlength="120" autocomplete="name" required></label>
                    <label>Email <span class="optional">(opsional)</span><input type="email" name="customer_email" value="{{ old('customer_email', auth()->user()?->email) }}" placeholder="nama@email.com" maxlength="150" autocomplete="email"></label>
                </div>
                <label class="full-label">Keperluan sesi <span class="optional">(opsional)</span><textarea name="purpose" rows="3" maxlength="1000" placeholder="Contoh: podcast edukasi, wawancara, atau produksi konten">{{ old('purpose') }}</textarea></label>
                <label class="participant-label">Jumlah peserta<input type="number" name="participants" id="participants" min="1" max="{{ $studios->max('capacity') ?? 1 }}" value="{{ old('participants', 2) }}" required><small id="capacityHint">Pilih studio untuk melihat kapasitas.</small></label>
            </section>

            <section class="panel booking-panel">
                <div class="section-title"><span class="section-number">04</span><div><h2>Peralatan tambahan</h2><p>Pilih perlengkapan yang ingin disiapkan bersama studio.</p></div></div>
                <div class="equipment-grid">
                    @php($equipmentImages = ['headphones' => 'equipment-headphones.svg', 'audio mixer' => 'equipment-mixer.svg', 'condenser microphone' => 'equipment-microphone.svg', 'camera' => 'equipment-camera.svg', 'tripod' => 'equipment-tripod.svg', 'ring light' => 'equipment-ringlight.svg'])
                    @forelse ($equipment as $item)
                        @php($equipmentImage = $equipmentImages[strtolower($item->name)] ?? 'equipment-microphone.svg')
                        <label class="equipment-option {{ $item->stock < 1 ? 'unavailable' : '' }}" data-search-item>
                            <img src="{{ asset('images/'.$equipmentImage) }}" alt="" loading="lazy">
                            <span class="equipment-copy"><strong>{{ $item->name }}</strong><small>{{ $item->stock > 0 ? 'Stok tersedia' : 'Sedang habis' }}</small></span>
                            <input type="checkbox" name="equipment[]" value="{{ $item->id }}" {{ in_array($item->id, old('equipment', [])) ? 'checked' : '' }} {{ $item->stock < 1 ? 'disabled' : '' }} aria-label="Pilih {{ $item->name }}">
                        </label>
                    @empty
                        <div class="empty-state"><strong>Belum ada peralatan aktif.</strong><span>Kamu tetap dapat memesan studio tanpa peralatan tambahan.</span></div>
                    @endforelse
                </div>
            </section>

            <section class="booking-summary" aria-live="polite"><div><span>ESTIMASI BIAYA STUDIO</span><strong id="priceEstimate">Pilih studio</strong></div><small>Biaya akhir mengikuti lama sesi yang dipesan.</small></section>
            <div class="form-actions"><a class="btn btn-light" href="{{ route('dashboard') }}">Kembali</a><button class="btn btn-primary" type="submit" @disabled($studios->isEmpty())>Simpan booking <span aria-hidden="true">→</span></button></div>
        </form>
        <p class="page-footer">© {{ date('Y') }} LabInvent Podcast · Reservasi studio kampus</p>
    </section>

    <script>
        const studioRadios = document.querySelectorAll('input[name="studio_id"]');
        const participants = document.getElementById('participants');
        const capacityHint = document.getElementById('capacityHint');
        const priceEstimate = document.getElementById('priceEstimate');
        const startDate = document.querySelector('input[name="start_date"]');
        const endDate = document.querySelector('input[name="end_date"]');
        const startTime = document.querySelector('input[name="start_time"]');
        const endTime = document.querySelector('input[name="end_time"]');

        function updateBookingSummary() {
            const selectedStudio = document.querySelector('input[name="studio_id"]:checked');
            if (!selectedStudio) return;

            const capacity = Number(selectedStudio.dataset.capacity);
            participants.max = String(capacity);
            capacityHint.textContent = `Maksimal ${capacity} peserta untuk studio ini.`;
            if (Number(participants.value) > capacity) participants.value = String(capacity);

            const beginsAt = new Date(`${startDate.value}T${startTime.value}`);
            const endsAt = new Date(`${endDate.value}T${endTime.value}`);
            const hours = Math.max(1, Math.ceil((endsAt - beginsAt) / 3600000));
            const amount = Number(selectedStudio.dataset.price) * hours;
            priceEstimate.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(amount)}`;
        }

        studioRadios.forEach((radio) => radio.addEventListener('change', updateBookingSummary));
        [participants, startDate, endDate, startTime, endTime].forEach((field) => field?.addEventListener('change', updateBookingSummary));
        startDate?.addEventListener('change', () => {
            endDate.min = startDate.value;
            if (endDate.value < startDate.value) endDate.value = startDate.value;
            updateBookingSummary();
        });
        updateBookingSummary();
    </script>
@endsection
