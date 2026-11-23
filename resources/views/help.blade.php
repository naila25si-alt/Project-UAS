@extends('app')

@section('title', 'Pusat Bantuan | LabInvent Podcast')

@section('content')
    <section class="help-page">
        <div class="help-hero"><div><span class="eyebrow">KAMI SIAP MEMBANTU</span><h1>Mulai sesi tanpa<br>bingung.</h1><p>Jawaban singkat untuk membantu kamu merencanakan dan menggunakan studio.</p><a href="{{ route('booking.index') }}" class="btn btn-primary">Buka formulir booking <span aria-hidden="true">→</span></a></div><div class="help-illustration" aria-hidden="true"><img src="{{ asset('images/equipment-microphone.svg') }}" alt=""></div></div>
        <div class="help-content-grid">
            <section class="faq-section"><span class="section-overline">PERTANYAAN UMUM</span><h2>Informasi booking</h2>
                <details class="faq-item" open><summary>Bagaimana cara memesan studio?<span>+</span></summary><p>Pilih menu <a href="{{ route('booking.index') }}">Booking Studio</a>, tentukan studio, tanggal, jam mulai dan selesai, lalu lengkapi detail pemesan. Booking tersimpan dengan status menunggu konfirmasi.</p></details>
                <details class="faq-item"><summary>Bagaimana cara melihat pemesanan saya?<span>+</span></summary><p>Buka menu <a href="{{ route('booking.history') }}">Riwayat Booking</a>. Halaman ini menampilkan jadwal, studio, peralatan, status, serta estimasi biaya.</p></details>
                <details class="faq-item"><summary>Kenapa jadwal tidak dapat dipilih?<span>+</span></summary><p>Studio mungkin sudah memiliki booking pada rentang waktu itu, atau jumlah peserta melebihi kapasitas. Coba pilih waktu atau studio lain.</p></details>
                <details class="faq-item"><summary>Apakah peralatan tersedia untuk dipinjam?<span>+</span></summary><p>Ya. Pilih peralatan yang stoknya tersedia pada formulir booking. Perlengkapan akan dicatat bersama reservasi studio.</p></details>
            </section>
            <aside class="help-contact-card"><span class="contact-icon"><svg viewBox="0 0 24 24" fill="none"><path d="M4 5h16v12H8l-4 3V5Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M8 9h8m-8 4h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></span><span class="section-overline">SIAP MEMULAI?</span><h2>Atur sesi berikutnya</h2><p>Pilih ruang dan waktu yang tersedia. Jika jadwal sudah terisi, sistem akan meminta kamu memilih waktu lain.</p><a class="contact-link" href="{{ route('booking.index') }}">Buka formulir booking <span aria-hidden="true">→</span></a><small>Untuk konfirmasi khusus, hubungi pengelola laboratorium kampus.</small></aside>
        </div>
    </section>
@endsection
