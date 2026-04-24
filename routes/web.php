<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// 1. Tampilan Utama
Route::get('/', function () {
    $chirps = session('chirps', []);
    return view('welcome', ['chirps' => $chirps]);
});

// 2. Proses Simpan ke Session
Route::post('/post-chirp', function (Request $request) {
    $request->validate([
        'message' => 'required|string|max:255',
    ]);

    $chirps = session('chirps', []);

    array_unshift($chirps, [
        'name' => 'Guest User',
        'message' => $request->message,
        'time' => now()->diffForHumans(),
    ]);

    session(['chirps' => $chirps]);

    return redirect('/');
})->name('chirps.store');