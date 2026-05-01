<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $chirps = session()->get('temporary_chirps', []);
    
    return view('welcome', ['chirps' => $chirps]);
})->name('home');

Route::post('/login-action', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
    ]);

    $user = User::firstOrCreate(
        ['email' => $request->email],
        [
            'name' => $request->name, 
            'password' => Hash::make('password') 
        ]
    );

    Auth::login($user);
    $request->session()->regenerate();

    return redirect()->route('home')->with('success', 'Selamat datang, ' . $user->name . '!');
})->name('login');

Route::post('/logout-action', function (Request $request) {

    Auth::logout();
    
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('home')->with('success', 'Berhasil keluar sistem.');
})->name('logout');

Route::post('/post-chirp', function (Request $request) {
    if (!Auth::check()) {
        return redirect()->route('home')->with('error', 'Silakan login terlebih dahulu!');
    }
    
    $request->validate([
        'message' => 'required|string|max:255'
    ]);

    $temporaryChirps = session()->get('temporary_chirps', []);

    array_unshift($temporaryChirps, (object)[
        'message' => $request->message,
        'user' => (object)['name' => Auth::user()->name], 
        'created_at' => now(), 
    ]);

    session()->put('temporary_chirps', $temporaryChirps);

    return redirect()->route('home')->with('success', 'Kicauan kamu telah muncul!');
})->name('chirps.store');