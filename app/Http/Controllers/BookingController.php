<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    private function studios(): array
    {
        return [
            ['id' => 'A', 'name' => 'Studio A : The Proffesional', 'capacity' => 4,
             'features' => 'acoustic foam, pro mics/mixer', 'color' => '#c58b4a'],
            ['id' => 'B', 'name' => 'Studio B : The Cozy Corner', 'capacity' => 2,
             'features' => 'natural light, cozy seating', 'color' => '#9cc2b5'],
            ['id' => 'C', 'name' => 'Studio B : The Creator Space', 'capacity' => 2,
             'features' => 'green screen, lighting, audio interface', 'color' => '#4a9d5b'],
        ];
    }

    public function create()
{
    $studios = [
        [
            'id' => 'A',
            'name' => 'Studio A - Podcast Utama',
            'color' => '#3b82f6',
            'capacity' => '4 Orang',
            'features' => '4 Mic Condenser, Mixer, Kamera 4K',
        ],
        [
            'id' => 'B',
            'name' => 'Studio B - Mini Talkshow',
            'color' => '#10b981',
            'capacity' => '2 Orang',
            'features' => '2 Mic Dynamic, Audio Interface',
        ],
    ];

    $equipments = ['Tripod', 'Lighting Softbox', 'Headphone Monitor', 'Teleprompter'];

    return view('booking', compact('studios', 'equipments'));
}

    public function store(Request $request)
    {
        $request->validate([
            'studio'       => ['required', 'in:A,B,C'],
            'start_date'   => ['required', 'date'],
            'start_time'   => ['required'],
            'end_date'     => ['required', 'date', 'after_or_equal:start_date'],
            'end_time'     => ['required'],
            'purpose'      => ['required', 'string', 'max:255'],
            'participants' => ['required', 'integer', 'min:1'],
            'equipment'    => ['nullable', 'array'],
        ]);

        return redirect()->route('booking.create')
            ->with('success', 'Data booking valid. Penyimpanan ke database menyusul.');
    }
}
