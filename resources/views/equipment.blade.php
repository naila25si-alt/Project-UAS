
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment</title>
    <link rel="stylesheet" href="{{ asset('css/facilities.css') }}">
</head>
<body>

<div class="page-container">

    <div class="page-header">
        <h1>Studio Equipment</h1>
        <p>Lihat berbagai peralatan yang tersedia di studio.</p>
    </div>

    <div class="studio-grid">

        @forelse($equipment as $item)

            <div class="facility-card">

                @php
                    $image = $item->image ?? null;
                @endphp

                @if($image)
                    <img
                        src="{{ filter_var($image, FILTER_VALIDATE_URL) ? $image : asset('storage/'.$image) }}"
                        class="facility-image"
                        alt="Equipment"
                    >
                @else
                    <div class="image-placeholder">
                        🎧
                    </div>
                @endif

                <div class="card-content">

                    <h3>
                        {{ $item->name ?? $item->nama ?? 'Equipment' }}
                    </h3>

                    <p>
                        {{ $item->description ?? $item->deskripsi ?? 'Peralatan studio tersedia untuk kebutuhan produksi.' }}
                    </p>

                    <div class="card-footer">
                        <span>
                            {{ $item->status ?? 'Tersedia' }}
                        </span>
                    </div>

                </div>
            </div>

        @empty

            <p>Belum ada peralatan yang tersedia.</p>

        @endforelse

    </div>

</div>

</body>
</html>
