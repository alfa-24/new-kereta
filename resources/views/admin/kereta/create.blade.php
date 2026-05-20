<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kereta - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-sky-50 text-slate-900">
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center justify-between rounded-3xl bg-white p-6 shadow-lg">
            <div>
                <h1 class="mt-3 text-4xl font-bold text-slate-900">Tambah Kereta Baru</h1>
                <p class="mt-2 text-slate-600">Atur nama kereta dan stasiun yang akan dilewati.</p>
            </div>
            <a href="/" class="rounded-full bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">Kembali ke Beranda</a>
        </div>

        <div class="rounded-[2rem] bg-white p-8 shadow-2xl shadow-slate-300/20">
            @if(session('success'))
                <div class="mb-6 rounded-3xl border border-green-200 bg-green-50 p-5 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 p-5 text-red-800">
                    <p class="font-semibold">Periksa kembali data Anda:</p>
                    <ul class="mt-3 list-disc space-y-1 pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.kereta.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label class="text-sm font-semibold uppercase tracking-[0em] text-slate-500" for="nama_kereta">Nama Kereta</label>
                    <input type="text" id="nama_kereta" name="nama_kereta" value="{{ old('nama_kereta') }}" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4 text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200" placeholder="Masukkan nama kereta">
                </div>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0em] text-slate-500">Stasiun yang dilewati</p>
                        <p class="mt-1 text-sm text-slate-500">Centang stasiun yang akan dilewati dan atur urutannya.</p>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        @foreach($stations as $station)
                            <label class="flex flex-col rounded-3xl border border-slate-200 bg-slate-50 p-4 transition hover:border-blue-300">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-3">
                                        <input type="checkbox" name="stations[]" value="{{ $station->id_stasiun }}" class="h-5 w-5 rounded border-slate-300 text-blue-600 focus:ring-blue-500" {{ in_array($station->id_stasiun, old('stations', [])) ? 'checked' : '' }}>
                                        <div>
                                            <p class="font-semibold text-slate-900">{{ $station->nama_stasiun }}</p>
                                            <p class="text-sm text-slate-500">{{ $station->kota }}</p>
                                        </div>
                                    </div>
                                    <input type="number" name="orders[{{ $station->id_stasiun }}]" min="1" value="{{ old('orders.' . $station->id_stasiun) }}" placeholder="Urutan" class="w-24 rounded-3xl border border-slate-200 bg-white px-4 py-2 text-slate-900 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Minimal pilih 2 stasiun untuk membuat jalur.</p>
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center rounded-full bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700">Simpan Kereta</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
