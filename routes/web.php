<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PoliklinikController;
use App\Http\Controllers\DokterController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::resource('poliklinik', PoliklinikController::class);
    Route::post('/poliklinik/delete-multiple', [PoliklinikController::class, 'deleteMultiple']);
    Route::get('/polikliniks/data', [PoliklinikController::class, 'getData'])->name('polikliniks.data');

    Route::resource('dokter', DokterController::class);
    Route::post('/dokter/delete-multiple', [DokterController::class, 'deleteMultiple']);
    Route::get('/dokters/data', [DokterController::class, 'getData'])->name('dokters.data');

});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login')->with('toast', [
        'type' => 'success', // success | danger | warning | info
        'message' => 'You have been logged out successfully.',
    ]);
})->name('logout');
