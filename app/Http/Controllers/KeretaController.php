<?php

namespace App\Http\Controllers;

use App\Models\Kereta;
use Illuminate\Http\Request;

class KeretaController extends Controller
{
    public function show(Kereta $kereta)
    {
        $kereta->load(['keretaStasiunOrdered.stasiun']);

        $mapPoints = $kereta->keretaStasiunOrdered
            ->map(function ($item) {
                $station = $item->stasiun;
                return $station && $station->latitude && $station->longitude
                    ? ['lat' => $station->latitude, 'lng' => $station->longitude]
                    : null;
            })
            ->filter()
            ->values()
            ->all();

        return view('kereta.show', [
            'kereta' => $kereta,
            'mapPoints' => $mapPoints,
        ]);
    }
}
