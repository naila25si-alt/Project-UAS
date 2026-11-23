<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Equipment;
use App\Models\Studio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $studios = Studio::where('is_active', true)->orderBy('id')->get();
        $equipment = Equipment::where('is_active', true)->orderBy('name')->get();

        return view('booking', compact('studios', 'equipment'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_email' => ['nullable', 'email', 'max:150'],
            'studio_id' => ['required', 'exists:studios,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'end_time' => ['required', 'date_format:H:i'],
            'purpose' => ['nullable', 'string', 'max:1000'],
            'participants' => ['required', 'integer', 'min:1', 'max:100'],
            'equipment' => ['nullable', 'array'],
            'equipment.*' => ['integer', 'distinct', 'exists:equipment,id'],
        ]);

        $start = strtotime($validated['start_date'].' '.$validated['start_time']);
        $end = strtotime($validated['end_date'].' '.$validated['end_time']);

        if ($end <= $start) {
            throw ValidationException::withMessages([
                'end_time' => 'Waktu selesai harus setelah waktu mulai.',
            ]);
        }

        $studio = Studio::findOrFail($validated['studio_id']);

        if ($validated['participants'] > $studio->capacity) {
            throw ValidationException::withMessages([
                'participants' => 'Jumlah peserta melebihi kapasitas studio ('.$studio->capacity.').',
            ]);
        }

        $conflict = Booking::where('studio_id', $studio->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereRaw(
                "TIMESTAMP(start_date, start_time) < ? AND TIMESTAMP(end_date, end_time) > ?",
                [
                    date('Y-m-d H:i:s', $end),
                    date('Y-m-d H:i:s', $start),
                ]
            )
            ->exists();

        if ($conflict) {
            throw ValidationException::withMessages([
                'start_time' => 'Studio sudah dipesan pada rentang waktu tersebut. Silakan pilih jadwal lain.',
            ]);
        }

        $hours = max(1, (int) ceil(($end - $start) / 3600));
        $booking = DB::transaction(function () use ($validated, $studio, $hours) {
            $booking = Booking::create([
                'studio_id' => $studio->id,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'] ?? null,
                'purpose' => $validated['purpose'] ?? null,
                'participants' => $validated['participants'],
                'start_date' => $validated['start_date'],
                'start_time' => $validated['start_time'],
                'end_date' => $validated['end_date'],
                'end_time' => $validated['end_time'],
                'status' => 'pending',
                'total_price' => $studio->price_per_hour * $hours,
            ]);

            $equipmentIds = $validated['equipment'] ?? [];
            $booking->equipment()->sync(
                collect($equipmentIds)->mapWithKeys(fn ($id) => [$id => ['quantity' => 1]])->all()
            );

            return $booking;
        });

        return redirect()
            ->route('booking.index')
            ->with('success', 'Booking berhasil disimpan! Nomor booking: #'.$booking->id);
    }

    public function myBookings(): View
    {
        $bookings = Booking::with(['studio', 'equipment'])
            ->latest()
            ->paginate(10);

        return view('my-bookings', compact('bookings'));
    }


public function dashboard(): View
{
    // Menghitung seluruh booking
    $totalBookings = Booking::count();

    // Menghitung booking yang menunggu persetujuan
    $pendingBookings = Booking::where('status', 'pending')->count();

    // Menghitung booking yang sudah dikonfirmasi
    $confirmedBookings = Booking::where('status', 'confirmed')->count();

    // Menghitung studio yang aktif
    $totalStudios = Studio::where('is_active', true)->count();

    // Menghitung equipment yang aktif
    $totalEquipment = Equipment::where('is_active', true)->count();

    // Mengambil 6 booking terbaru
    $recentBookings = Booking::with('studio')
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
public function create()
    {
        // Data contoh jadwal yang sudah terisi hari ini (nanti bisa diambil dari Database)
        $bookedSchedules = [
            ['studio' => 'Studio Musik A', 'time' => '09:00 - 11:00', 'by' => 'UKM Band'],
            ['studio' => 'Studio Podcast', 'time' => '13:00 - 15:00', 'by' => 'Himpunan TI'],
        ];

        return view('booking.create', compact('bookedSchedules'));
    }

    // Menerima data dari Form dan meneruskannya ke Halaman Review
    public function review(Request $request)
    {
        // Validasi input sebelum masuk ke halaman review
        $validated = $request->validate([
            'studio'       => 'required|string',
            'date'         => 'required|date|after_or_equal:today',
            'time'         => 'required',
            'duration'     => 'required|integer|min:1|max:5',
            'purpose'      => 'required|string|max:255',
            'participants' => 'required|integer|min:1|max:30',
            'equipment'    => 'nullable|array',
        ]);

        // Kirim data hasil input ke view halaman review kamu
        return view('booking.review', ['booking' => $validated]);
    }

}


