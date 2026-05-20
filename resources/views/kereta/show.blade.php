<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kereta - {{ $kereta->nama_kereta }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>
<body class="min-h-screen bg-sky-50 text-slate-900">
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center justify-between rounded-3xl bg-white p-6 shadow-lg">
            <div>
                <p class="text-sm uppercase tracking-[0em] text-sky-500">Detail Kereta</p>
                <h1 class="mt-3 text-4xl font-bold text-slate-900">{{ $kereta->nama_kereta }}</h1>
                <p class="mt-2 text-slate-600">Rute lengkap dan stasiun yang dilewati kereta ini.</p>
            </div>
            <a href="/" class="rounded-full bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">Kembali ke Beranda</a>
        </div>

        <div class="mb-8 overflow-hidden rounded-[2rem] bg-gradient-to-br from-sky-500 via-blue-500 to-blue-700 p-1 shadow-2xl shadow-slate-400/10">
            <div class="rounded-[1.75rem] bg-white p-4 sm:p-6">
                <div class="h-[400px] rounded-3xl overflow-hidden border border-slate-200" id="route-map"></div>
                <div class="mt-6 space-y-3">
                    <p class="text-sm uppercase tracking-[0em] text-sky-500">Jalur Kereta</p>
                    <h2 class="text-2xl font-semibold text-slate-900">{{ $kereta->nama_kereta }}</h2>
                    <p class="text-sm text-slate-600">Menampilkan jalur kereta dengan OpenStreetMap dan Leaflet.</p>
                    @if ($kereta->keretaStasiunOrdered->count() >= 2)
                        <p class="text-sm text-slate-500">Dari <span class="font-semibold">{{ $kereta->keretaStasiunOrdered->first()->stasiun->nama_stasiun }}</span> ke <span class="font-semibold">{{ $kereta->keretaStasiunOrdered->last()->stasiun->nama_stasiun }}</span></p>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1fr_0.9fr]">
            <div class="rounded-3xl bg-white p-6 shadow-lg">
                <h2 class="text-2xl font-semibold text-slate-900">Stasiun yang dilewati</h2>
                <div class="mt-6 space-y-4">
                    @forelse ($kereta->keretaStasiunOrdered as $item)
                        <div class="rounded-3xl border border-slate-200 p-5">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="text-sm text-slate-500">Urutan {{ $item->urutan }}</p>
                                    <p class="mt-2 text-xl font-semibold text-slate-900">{{ $item->stasiun->nama_stasiun ?? 'Stasiun tidak tersedia' }}</p>
                                    <p class="text-sm text-slate-500">{{ $item->stasiun->kota ?? 'Kota tidak tersedia' }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6 text-slate-600">
                            Tidak ada data stasiun yang dilampirkan untuk kereta ini.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-3xl bg-gradient-to-br from-sky-500 via-blue-500 to-blue-700 p-6 shadow-lg text-white">
                <h3 class="text-xl font-semibold">Ringkasan Rute</h3>
                @if ($kereta->keretaStasiunOrdered->count() >= 2)
                    <p class="mt-4 text-sm text-sky-100">Asal: <span class="font-semibold">{{ $kereta->keretaStasiunOrdered->first()->stasiun->nama_stasiun }}</span></p>
                    <p class="mt-2 text-sm text-sky-100">Tujuan: <span class="font-semibold">{{ $kereta->keretaStasiunOrdered->last()->stasiun->nama_stasiun }}</span></p>
                    <p class="mt-2 text-sm text-sky-100">Jumlah pemberhentian: <span class="font-semibold">{{ $kereta->keretaStasiunOrdered->count() }}</span></p>
                @else
                    <p class="mt-4 text-sm text-sky-100">Data stasiun belum lengkap untuk kereta ini.</p>
                @endif
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        function initMap() {
            const mapPoints = @json($mapPoints ?? []);
            const mapContainer = document.getElementById('route-map');

            if (mapPoints.length === 0) {
                mapContainer.innerHTML = '<div class="flex h-full items-center justify-center text-slate-500">Tidak ada data koordinat untuk ditampilkan</div>';
                return;
            }

            const latlngs = mapPoints.map(point => [point.lat, point.lng]);
            const map = L.map('route-map', { scrollWheelZoom: false }).setView(latlngs[0], 6);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19,
            }).addTo(map);

            L.polyline(latlngs, { color: '#0ea5e9', weight: 4, opacity: 0.9 }).addTo(map);

            latlngs.forEach((latlng, index) => {
                L.marker(latlng)
                    .addTo(map)
                    .bindPopup(`Stasiun ${index + 1}`)
                    .bindTooltip(`${index + 1}`, { permanent: true, direction: 'top', className: 'leaflet-tooltip-custom' });
            });

            const bounds = L.latLngBounds(latlngs);
            map.fitBounds(bounds, { padding: [40, 40] });
            setTimeout(() => map.invalidateSize(), 0);
        }

        window.addEventListener('load', initMap);
    </script>
</body>
</html>
