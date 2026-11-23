<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Equipment;
use App\Models\Studio;
use Carbon\Carbon;
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

        $start = Carbon::parse($validated['start_date'].' '.$validated['start_time']);
        $end = Carbon::parse($validated['end_date'].' '.$validated['end_time']);

        if ($start->isPast()) {
            throw ValidationException::withMessages([
                'start_time' => 'Waktu mulai harus setelah waktu sekarang.',
            ]);
        }

        if ($end->lessThanOrEqualTo($start)) {
            throw ValidationException::withMessages([
                'end_time' => 'Waktu selesai harus setelah waktu mulai.',
            ]);
        }

        $studio = Studio::where('is_active', true)->findOrFail($validated['studio_id']);

        if ($validated['participants'] > $studio->capacity) {
            throw ValidationException::withMessages([
                'participants' => 'Jumlah peserta melebihi kapasitas studio ('.$studio->capacity.').',
            ]);
        }

        $possibleConflicts = Booking::where('studio_id', $studio->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereDate('start_date', '<=', $validated['end_date'])
            ->whereDate('end_date', '>=', $validated['start_date'])
            ->get(['start_date', 'start_time', 'end_date', 'end_time']);

        $hasScheduleConflict = $possibleConflicts->contains(function (Booking $existingBooking) use ($start, $end): bool {
            $existingStart = Carbon::parse($existingBooking->start_date->format('Y-m-d').' '.$existingBooking->start_time);
            $existingEnd = Carbon::parse($existingBooking->end_date->format('Y-m-d').' '.$existingBooking->end_time);

            return $existingStart->lessThan($end) && $existingEnd->greaterThan($start);
        });

        if ($hasScheduleConflict) {
            throw ValidationException::withMessages([
                'start_time' => 'Studio sudah dipesan pada rentang waktu tersebut. Silakan pilih jadwal lain.',
            ]);
        }

        $equipmentIds = $validated['equipment'] ?? [];
        if ($equipmentIds !== [] && Equipment::whereIn('id', $equipmentIds)->where('stock', '<', 1)->exists()) {
            throw ValidationException::withMessages([
                'equipment' => 'Salah satu peralatan yang dipilih sedang tidak tersedia.',
            ]);
        }

        $hours = max(1, (int) ceil($start->diffInSeconds($end) / 3600));
        $booking = DB::transaction(function () use ($validated, $studio, $hours, $equipmentIds): Booking {
            $booking = Booking::create([
                'studio_id' => $studio->id,
                'customer_name' => $validated['customer_name'],
                'customer_email' => auth()->user()->email,
                'purpose' => $validated['purpose'] ?? null,
                'participants' => $validated['participants'],
                'start_date' => $validated['start_date'],
                'start_time' => $validated['start_time'],
                'end_date' => $validated['end_date'],
                'end_time' => $validated['end_time'],
                'status' => 'pending',
                'total_price' => $studio->price_per_hour * $hours,
            ]);

            $booking->equipment()->sync(
                collect($equipmentIds)->mapWithKeys(fn ($id): array => [$id => ['quantity' => 1]])->all()
            );

            return $booking;
        });

        return redirect()
            ->route('booking.history')
            ->with('success', 'Booking berhasil disimpan! Nomor booking: #'.$booking->id);
    }

    public function myBookings(): View
    {
        $bookingsQuery = Booking::with(['studio', 'equipment'])->latest();

        if (auth()->user()->role !== 'admin') {
            $bookingsQuery->where('customer_email', auth()->user()->email);
        }

        $bookings = $bookingsQuery->paginate(10);

        return view('my-bookings', compact('bookings'));
    }

    public function updateStatus(Request $request, Booking $booking): RedirectResponse
    {
        abort_unless(auth()->user()->role === 'admin', 403);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,cancelled'],
        ]);

        $booking->update(['status' => $validated['status']]);

        return back()->with('success', 'Status booking #'.$booking->id.' berhasil diperbarui.');
    }

    public function dashboard(): View
    {
        if (auth()->user()->role === 'admin') {
            $totalBookings = Booking::count();
            $pendingBookings = Booking::where('status', 'pending')->count();
            $confirmedBookings = Booking::where('status', 'confirmed')->count();
            $totalStudios = Studio::where('is_active', true)->count();
            $totalEquipment = Equipment::where('is_active', true)->count();
            $recentBookings = Booking::with('studio')->latest()->take(8)->get();

            return view('dashboard.admin', compact(
                'totalBookings',
                'pendingBookings',
                'confirmedBookings',
                'totalStudios',
                'totalEquipment',
                'recentBookings'
            ));
        }

        $studentBookings = Booking::with('studio')
            ->where('customer_email', auth()->user()->email);
        $totalBookings = (clone $studentBookings)->count();
        $pendingBookings = (clone $studentBookings)->where('status', 'pending')->count();
        $confirmedBookings = (clone $studentBookings)->where('status', 'confirmed')->count();
        $recentBookings = (clone $studentBookings)->latest()->take(5)->get();
        $upcomingBooking = (clone $studentBookings)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) {
                $query->whereDate('start_date', '>', today())
                    ->orWhere(function ($todayQuery) {
                        $todayQuery->whereDate('start_date', today())
                            ->whereTime('start_time', '>=', now()->format('H:i:s'));
                    });
            })
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->first();

        return view('dashboard.student', compact(
            'totalBookings',
            'pendingBookings',
            'confirmedBookings',
            'recentBookings',
            'upcomingBooking'
        ));
    }
}
