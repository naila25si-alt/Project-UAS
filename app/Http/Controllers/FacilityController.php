<?php

namespace App\Http\Controllers;

use App\Models\Studio;
use App\Models\Equipment;

class FacilityController extends Controller
{
     // Halaman Studios
    public function studios()
    {
        $studios = Studio::all();

        return view('studios', compact('studios'));
    }

    // Halaman Equipment
    public function equipment()
    {
        $equipment = Equipment::all();

        return view('equipment', compact('equipment'));
    }

    // Halaman Help
    public function help()
    {
        return view('help');
    }

}
