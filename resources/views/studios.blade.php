
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Studios</title>
    <link rel="stylesheet" href="{{ asset('css/facilities.css') }}">
</head>
<body>

<div class="page-container">

    <div class="page-header">
        <h1>Available Studios</h1>
        <p>Temukan studio yang sesuai dengan kebutuhanmu.</p>
    </div>

    <div class="studio-grid">

        @forelse($studios as $studio)

            <div class="facility-card">

                @php
                    $image = $studio->image ?? null;
                @endphp

                @if($image)
                    <img
                        src="{{ filter_var($image, FILTER_VALIDATE_URL) ? $image : asset('storage/'.$image) }}"
                        class="facility-image"
                        alt="Studio"
                    >
                @else
                    <div class="image-placeholder">
                        🎙️
                    </div>
                @endif

                <div class="card-content">

                    <h3>
                        {{ $studio->name ?? $studio->nama ?? 'Studio' }}
                    </h3>

                    <p>
                        {{ $studio->description ?? $studio->deskripsi ?? 'Studio untuk kebutuhan rekaman dan produksi.' }}
                    </p>

                    <div class="card-footer">
                        <span>
                            {{ $studio->price ?? $studio->harga ?? 'Hubungi kami' }}
                        </span>

                        <a href="{{ route('booking.index') }}"
                           class="book-button">
                            Book Now
                        </a>
                    </div>

                </div>
            </div>

        @empty

            <p>Belum ada studio yang tersedia.</p>

        @endforelse

    </div>

</div>

</body>
</html>
