<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeretaController;
use App\Http\Controllers\Admin\KeretaController as AdminKeretaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/kereta/{kereta}', [KeretaController::class, 'show'])->name('kereta.show');

Route::middleware('auth')->group(function () {
    Route::get('/admin/kereta/create', [AdminKeretaController::class, 'create'])->name('admin.kereta.create');
    Route::post('/admin/kereta', [AdminKeretaController::class, 'store'])->name('admin.kereta.store');
});

Route::get('/admin/login', function () {
    return view('auth.login');
});

Route::post('/admin/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Hanya akun admin yang dapat masuk di halaman ini.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();
        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
});

Route::post('/admin/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
});
