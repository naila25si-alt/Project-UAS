<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Studio;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Studio::query()->delete();
        Equipment::query()->delete();

        Studio::create([
            'name' => 'Studio A: The Professional',
            'subtitle' => 'Podcasting pro',
            'description' => 'Studio profesional untuk produksi podcast.',
            'capacity' => 4,
            'features' => 'Acoustic foam, Pro mic, multi-camera',
            'image' => 'https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?w=900',
            'color' => '#dbeafe',
            'price_per_hour' => 150000,
        ]);

        Studio::create([
            'name' => 'Studio B: The Cozy Corner',
            'subtitle' => 'Casual & bright',
            'description' => 'Studio nyaman untuk podcast santai.',
            'capacity' => 6,
            'features' => 'Natural light, cozy seating',
            'image' => 'https://images.unsplash.com/photo-1593078166038-6b5c7f9b2c6f?w=900',
            'color' => '#dcfce7',
            'price_per_hour' => 125000,
        ]);

        Studio::create([
            'name' => 'Studio C: The Creator Space',
            'subtitle' => 'Creative space',
            'description' => 'Ruang kreatif untuk produksi konten.',
            'capacity' => 8,
            'features' => 'Green screen, lighting, video setup',
            'image' => 'https://images.unsplash.com/photo-1590609140263-2b7d4b2e8f4b?w=900',
            'color' => '#fef3c7',
            'price_per_hour' => 175000,
        ]);

        foreach ([
            ['Headphones', 'Headphone monitoring', 12],
            ['Audio Mixer', 'Mixer audio podcast', 4],
            ['Condenser Microphone', 'Mikrofon condenser', 10],
            ['Camera', 'Kamera video', 3],
            ['Tripod', 'Tripod kamera', 5],
            ['Ring Light', 'Lampu ring light', 5],
        ] as $item) {
            Equipment::create([
                'name' => $item[0],
                'description' => $item[1],
                'stock' => $item[2],
            ]);
        }
    }
}
