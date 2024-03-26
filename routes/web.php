<?php

use App\Models\Mobil;
use App\Models\Pelanggan;
use App\Models\Penyewaan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $pelangganCount = Pelanggan::count();
        $mobilCount = Mobil::count();
        $penyewaanCount = Penyewaan::count();
        return view('dashboard', compact('pelangganCount', 'mobilCount', 'penyewaanCount'));
    })->name('dashboard');

    Route::get('/permissions', function () {
        return view('permissions');
    })->name('permissions');

    Route::get('/roles', function () {
        return view('roles');
    })->name('roles');

    Route::get('/users', function () {
        return view('users');
    })->name('users');

    Route::get('/mobil', function () {
        return view('mobil');
    })->name('mobil');

    Route::get('/pelanggan', function () {
        return view('pelanggan');
    })->name('pelanggan');

    // Route samsat
    Route::get('/samsat', function () {
        return view('samsat');
    })->name('samsat');

    // Route pemeliharaan
    Route::get('/pemeliharaan', function () {
        return view('pemeliharaan');
    })->name('pemeliharaan');

    Route::get('/penyewaan', function () {
        return view('penyewaan');
    })->name('penyewaan');

    Route::get('/transaksi', function () {
        return view('transaksi');
    })->name('transaksi');
});
