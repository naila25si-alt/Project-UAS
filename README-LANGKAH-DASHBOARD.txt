LANGKAH 1 - MEMBUAT DASHBOARD LABINVENT

PENTING: File patch ini hanya menambahkan halaman dashboard. Tidak perlu migration baru.

A. Salin file:
- resources/views/dashboard.blade.php ke folder resources/views project Laravel.
- public/css/dashboard.css ke folder public/css project Laravel.

B. Tambahkan method berikut ke dalam class BookingController, sebelum kurung kurawal penutup class:

public function dashboard(): \Illuminate\View\View
{
    $totalBookings = \App\Models\Booking::count();

    $pendingBookings = \App\Models\Booking::where('status', 'pending')->count();

    $confirmedBookings = \App\Models\Booking::where('status', 'confirmed')->count();

    $totalStudios = \App\Models\Studio::where('is_active', true)->count();

    $totalEquipment = \App\Models\Equipment::where('is_active', true)->count();

    $recentBookings = \App\Models\Booking::with('studio')
        ->latest()
        ->take(6)
        ->get();

    return view('dashboard', compact(
        'totalBookings',
        'pendingBookings',
        'confirmedBookings',
        'totalStudios',
        'totalEquipment',
        'recentBookings'
    ));
}

Jika file BookingController sudah menggunakan import Booking, Studio, Equipment, cukup gunakan nama class tanpa awalan \App\Models\.

C. Buka routes/web.php.
Pastikan ada:
use App\Http\Controllers\BookingController;

Ganti route dashboard lama yang me-redirect ke booking:
Route::get('/dashboard', function () {
    return redirect()->route('booking.index');
})->name('dashboard');

Menjadi:
Route::get('/dashboard', [BookingController::class, 'dashboard'])
    ->name('dashboard');

Jangan menambahkan route dashboard kedua. Pertahankan route booking, my-bookings, login dan logout.

D. Jalankan di terminal project:
php artisan optimize:clear
php artisan route:list

E. Jalankan server:
php artisan serve

Buka:
http://127.0.0.1:8000/dashboard

ASUMSI STRUKTUR DATABASE
- bookings memiliki status, studio_id, customer_name, participants, start_date, start_time, end_time.
- studios memiliki is_active.
- equipment memiliki is_active.
- Model Booking memiliki relasi studio().
- Model Booking meng-cast start_date menjadi date.

Jika migrations/model project berbeda, sesuaikan nama kolom/relasi dengan struktur yang ada.
