<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kereta;
use App\Models\KeretaStasiun;
use App\Models\Stasiun;
use Illuminate\Http\Request;

class KeretaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (! $request->user()?->isAdmin()) {
                abort(403);
            }

            return $next($request);
        });
    }

    public function create()
    {
        $stations = Stasiun::orderBy('nama_stasiun')->get();

        return view('admin.kereta.create', [
            'stations' => $stations,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kereta' => 'required|string|max:255',
            'stations' => 'required|array|min:2',
            'stations.*' => 'integer|exists:tb_stasiun,id_stasiun',
            'orders' => 'array',
            'orders.*' => 'nullable|integer|min:1',
        ]);

        $stationIds = $validated['stations'];
        $orders = $validated['orders'] ?? [];

        $stationRoute = collect($stationIds)
            ->map(function ($stationId) use ($orders) {
                return [
                    'id_stasiun' => $stationId,
                    'urutan' => isset($orders[$stationId]) ? (int) $orders[$stationId] : null,
                ];
            })
            ->sortBy(function ($item) {
                return $item['urutan'] ?? PHP_INT_MAX;
            })
            ->values();

        $kereta = Kereta::create([
            'nama_kereta' => $validated['nama_kereta'],
        ]);

        foreach ($stationRoute as $index => $routeItem) {
            KeretaStasiun::create([
                'id_kereta' => $kereta->id_kereta,
                'id_stasiun' => $routeItem['id_stasiun'],
                'urutan' => $routeItem['urutan'] ?? ($index + 1),
            ]);
        }

        return redirect()->route('admin.kereta.create')
            ->with('success', 'Kereta baru berhasil ditambahkan dan jalurnya telah disimpan.');
    }
}
