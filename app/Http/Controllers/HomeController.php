<?php

namespace App\Http\Controllers;

use App\Models\Kereta;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $trains = Kereta::with(['keretaStasiun.stasiun'])->get();
        $mapTrain = $trains->first();

        $mapPoints = [];
        if ($mapTrain) {
            $mapPoints = $mapTrain->keretaStasiunOrdered
                ->map(function ($item) {
                    $station = $item->stasiun;
                    return $station && $station->latitude && $station->longitude
                        ? ['lat' => $station->latitude, 'lng' => $station->longitude]
                        : null;
                })
                ->filter()
                ->values()
                ->all();
        }

        return view('welcome', [
            'trains' => $trains,
            'mapTrain' => $mapTrain,
            'mapPoints' => $mapPoints,
        ]);
    }
}
