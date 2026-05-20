<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jalur Kereta Indonesia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>
<body class="bg-sky-50 text-slate-900">
    <div class="min-h-screen bg-gradient-to-b from-sky-100 via-sky-200 to-white">
        <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md shadow-sm">
            <div class="mx-auto max-w-6xl px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-600 text-white text-lg font-bold">JK</span>
                        <div>
                            <p class="text-lg font-semibold text-slate-900">Jalur Kereta Indonesia</p>
                            <p class="text-sm text-slate-500">Sistem informasi jalur kereta nasional</p>
                        </div>
                    </div>
                    <nav class="flex flex-wrap items-center gap-3 text-sm font-medium text-slate-700">
                        
                        <a href="#fitur" class="hover:text-sky-700 transition">Kereta</a>
                        <a href="#tentang" class="hover:text-sky-700 transition">Tentang</a>
                        @auth
                            <form method="POST" action="{{ url('/admin/logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="rounded-full bg-slate-900 px-4 py-2 text-white shadow-sm hover:bg-slate-800 transition">
                                    Logout Admin
                                </button>
                            </form>
                        @else
                            <a href="{{ url('/admin/login') }}" class="rounded-full bg-blue-600 px-4 py-2 text-white shadow-sm hover:bg-blue-700 transition">Admin Login</a>
                        @endauth
                    </nav>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
            <section class="grid gap-10 lg:grid-cols-[1.2fr_0.8fr] items-center">
                <div class="space-y-8">
                    <div class="space-y-4">
                        <p class="inline-flex rounded-full bg-blue-100 px-4 py-2 text-sm font-semibold text-blue-700">Sistem Informasi Jalur Kereta</p>
                        <h1 class="text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl">Temukan jalur kereta, stasiun, dan waktu perjalanan dengan cepat.</h1>
                        <p class="max-w-2xl text-lg leading-8 text-slate-700">Kami berdedikasi untuk menampilkan jalur kereta, stasiun, dan estimasi waktu perjalanan Anda di seluruh Indonesia.</p>
                    </div>
                    <div class="flex flex-col gap-4 sm:flex-row">
                        
                        @auth
                            <a href="#admin-actions" class="inline-flex items-center justify-center rounded-full border border-blue-600 bg-white px-6 py-3 text-sm font-semibold text-blue-700 transition hover:bg-blue-50">Admin Dashboard</a>
                        @endauth
                    </div>
                </div>

                <div class="overflow-hidden rounded-[2rem] bg-gradient-to-br from-sky-500 via-blue-500 to-blue-700 p-1 shadow-2xl shadow-slate-400/10">
                    <div class="rounded-[1.75rem] bg-white p-4 sm:p-6">
                        <div class="h-[400px] rounded-3xl overflow-hidden border border-slate-200" id="map-container">
                            <div id="route-map" class="h-full w-full" style="height:100%; width:100%;"></div>
                        </div>
                        <div class="mt-6 space-y-3">
                            <h2 class="text-2xl font-semibold text-slate-900">{{ $mapTrain?->nama_kereta ?? 'Kereta Pilihan' }}</h2>
                            <p class="text-sm text-slate-600">Menampilkan jalur kereta dengan OpenStreetMap dan Leaflet.</p>
                            @if ($mapTrain && $mapTrain->keretaStasiunOrdered->count() >= 2)
                                <p class="text-sm text-slate-500">Dari <span class="font-semibold">{{ $mapTrain->keretaStasiunOrdered->first()->stasiun->nama_stasiun }}</span> ke <span class="font-semibold">{{ $mapTrain->keretaStasiunOrdered->last()->stasiun->nama_stasiun }}</span></p>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            @auth
            <section id="admin-actions" class="mt-12 rounded-[2rem] border border-blue-200 bg-white p-8 shadow-lg">
                <div class="max-w-5xl mx-auto">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-blue-600"></p>
                            <h2 class="mt-3 text-3xl font-bold text-slate-900">Selamat datang, Admin.</h2>
                            <p class="mt-3 text-slate-600">Siap menambahkan perjalanan baru?</p>
                        </div>
                        <div class="flex flex-col gap-3 sm:flex-row">
                            <a href="{{ route('admin.kereta.create') }}" class="inline-flex items-center justify-center rounded-full bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">Tambah Kereta</a>
                        
                            
                        </div>
                    </div>
                    <form id="logout-form-footer" action="{{ url('/admin/logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                    <div class="mt-8 grid gap-6 md:grid-cols-3">
                        <div class="rounded-3xl bg-slate-50 p-6">
                            <h3 class="text-xl font-semibold text-slate-900">Tambah Data</h3>
                            <p class="mt-3 text-slate-600">Masukkan stasiun baru, rute, atau kereta secara langsung dari panel admin.</p>
                        </div>
                        <div class="rounded-3xl bg-slate-50 p-6">
                            <h3 class="text-xl font-semibold text-slate-900">Perbarui Data</h3>
                            <p class="mt-3 text-slate-600">Ubah informasi stasiun dan rute dengan akses penuh ke sistem.</p>
                        </div>
                        <div class="rounded-3xl bg-slate-50 p-6">
                            <h3 class="text-xl font-semibold text-slate-900">Pantau Aktivitas</h3>
                            <p class="mt-3 text-slate-600">Akses kontrol admin untuk melihat status data dan manajemen sistem.</p>
                        </div>
                    </div>
                </div>
            </section>
            @endauth

            <section id="fitur" class="mt-24 space-y-10">
                <div class="space-y-3 text-center">
                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-blue-600">Kereta Kami</p>
                    <h2 class="text-3xl font-bold text-slate-900 sm:text-4xl">Semua Kereta yang Beroperasi</h2>
                </div>
                <div id="kereta-list" class="grid gap-6 md:grid-cols-3">
                    @forelse ($trains as $train)
                        @php
                            $firstStation = $train->keretaStasiunOrdered->first()?->stasiun;
                            $lastStation = $train->keretaStasiunOrdered->last()?->stasiun;
                        @endphp
                        <a href="{{ route('kereta.show', $train) }}" class="group rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                            <div class="flex items-center justify-between gap-4">
                                <span class="rounded-3xl bg-blue-100 px-4 py-2 text-sm font-semibold text-blue-700">Kereta</span>
                                
                            </div>
                            <h3 class="mt-6 text-2xl font-semibold text-slate-900">{{ $train->nama_kereta }}</h3>
                            <p class="mt-4 text-sm text-slate-500">Asal: <span class="font-semibold text-slate-900">{{ $firstStation->nama_stasiun ?? 'Belum terhubung' }}</span></p>
                            <p class="mt-2 text-sm text-slate-500">Tujuan: <span class="font-semibold text-slate-900">{{ $lastStation->nama_stasiun ?? 'Belum terhubung' }}</span></p>
                            <div class="mt-6 flex items-center justify-between text-sm text-slate-500">
                                <span>{{ $train->keretaStasiunOrdered->count() }} pemberhentian</span>
                                <span class="font-semibold text-blue-700 group-hover:text-blue-900">Selengkapnya →</span>
                            </div>
                        </a>
                    @empty
                        <div class="rounded-[2rem] border border-slate-200 bg-white p-8 text-center text-slate-600">
                            Tidak ada data kereta tersedia saat ini.
                        </div>
                    @endforelse
                </div>
            </section>

            <section id="tentang" class="mt-24 rounded-[2rem] bg-slate-900 px-8 py-14 text-white sm:px-12">
                <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                    <div class="space-y-5">
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-300">Tentang Sistem</p>
                        <h2 class="text-3xl font-bold sm:text-4xl">Website untuk pengelolaan jalur kereta Indonesia.</h2>
                        <p class="max-w-xl text-slate-300">Aplikasi Laravel ini menyatukan data kereta, stasiun, dan rute dengan tema biru terang untuk tampilan tetap sederhana namun profesional dan intuitif untuk pengguna.</p>
                    </div>
                    <div class="space-y-4 rounded-3xl bg-slate-800/80 p-8 shadow-2xl shadow-blue-900/30">
                        <div>
                            <p class="text-sm text-slate-400">Backend</p>
                            <p class="mt-2 text-lg font-semibold text-white">Laravel</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-400">Frontend</p>
                            <p class="mt-2 text-lg font-semibold text-white">Blade + Tailwind CSS</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-400">Database</p>
                            <p class="mt-2 text-lg font-semibold text-white">MySQL</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-slate-200 bg-white py-8">
            <div class="mx-auto flex max-w-6xl flex-col gap-6 px-4 text-slate-600 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
                <p>&copy; 2026 Jalur Kereta Indonesia. Semua hak cipta dilindungi.</p>
                <div class="flex flex-wrap gap-4 text-sm">
                    
                    
                    @auth
                        <form method="POST" action="{{ url('/admin/logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-slate-900 transition">Logout</button>
                        </form>
                    @else
                        <a href="{{ url('/admin/login') }}" class="hover:text-slate-900 transition">Admin Login</a>
                    @endauth
                </div>
            </div>
        </footer>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const mapPoints = @json($mapPoints ?? []);

        function initMap() {
            const mapContainer = document.getElementById('route-map');
            if (mapPoints.length === 0) {
                mapContainer.innerHTML = '<div class="flex h-full items-center justify-center text-slate-500">Tidak ada data koordinat untuk ditampilkan</div>';
                return;
            }

            const map = L.map('route-map', { scrollWheelZoom: false }).setView([mapPoints[0].lat, mapPoints[0].lng], 6);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19,
            }).addTo(map);

            const latlngs = mapPoints.map(point => [point.lat, point.lng]);
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
