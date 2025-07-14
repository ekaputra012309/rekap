<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\IncomesController;
use App\Http\Controllers\OutcomesController;
use App\Http\Controllers\GessController;
use App\Http\Controllers\DoomController;
use App\Http\Controllers\GibController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\SaldoController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('income', IncomesController::class);
    Route::post('/income/delete-multiple', [IncomesController::class, 'deleteMultiple']);
    Route::get('/incomes/data', [IncomesController::class, 'getData'])->name('incomes.data');

    Route::resource('outcome', OutcomesController::class);
    Route::post('/outcome/delete-multiple', [OutcomesController::class, 'deleteMultiple']);
    Route::get('/outcomes/data', [OutcomesController::class, 'getData'])->name('outcomes.data');

    Route::resource('gess', GessController::class);
    Route::post('/gess/delete-multiple', [GessController::class, 'deleteMultiple']);
    Route::get('/gesss/data', [GessController::class, 'getData'])->name('gesss.data');

    Route::resource('doom', DoomController::class);
    Route::post('/doom/delete-multiple', [DoomController::class, 'deleteMultiple']);
    Route::get('/dooms/data', [DoomController::class, 'getData'])->name('dooms.data');

    Route::resource('gib', GibController::class);
    Route::post('/gib/delete-multiple', [GibController::class, 'deleteMultiple']);
    Route::get('/gibs/data', [GibController::class, 'getData'])->name('gibs.data');

    Route::get('/profile', [HomeController::class, 'editProfile'])->name('profile.edit');
    Route::resource('pemasukan', PemasukanController::class);
    Route::post('/pemasukan/delete-multiple', [PemasukanController::class, 'deleteMultiple']);
    Route::get('/pemasukans/data', [PemasukanController::class, 'getData'])->name('pemasukans.data');

    Route::resource('pengeluaran', PengeluaranController::class);
    Route::post('/pengeluaran/delete-multiple', [PengeluaranController::class, 'deleteMultiple']);
    Route::get('/pengeluarans/data', [PengeluaranController::class, 'getData'])->name('pengeluarans.data');

    Route::resource('saldo', SaldoController::class);
    Route::get('/saldos/data', [SaldoController::class, 'getData'])->name('saldos.data');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'generate'])->name('laporan.cetak');

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
