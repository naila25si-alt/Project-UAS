<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Studio;
use Illuminate\View\View;

class FacilityController extends Controller
{
    // Halaman Studios
    public function studios(): View
    {
        $studios = Studio::where('is_active', true)->orderBy('id')->get();

        return view('studios', compact('studios'));
    }

    // Halaman Equipment
    public function equipment(): View
    {
        $equipment = Equipment::where('is_active', true)->orderBy('name')->get();

        return view('equipment', compact('equipment'));
    }

    // Halaman Help
    public function help(): View
    {
        return view('help');
    }
}
