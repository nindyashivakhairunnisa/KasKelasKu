<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserPembayaranController;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Authenticated routes
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/siswa', [SiswaController::class, 'index'])->name('admin.siswa.index');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('admin.siswa.create');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('admin.siswa.store');
    Route::get('/siswa/{siswa}/edit', [SiswaController::class, 'edit'])->name('admin.siswa.edit');
    Route::put('/siswa/{siswa}', [SiswaController::class, 'update'])->name('admin.siswa.update');
    Route::delete('/siswa/{siswa}', [SiswaController::class, 'destroy'])->name('admin.siswa.destroy');

    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('admin.transaksi.index');
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('admin.transaksi.create');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('admin.transaksi.store');
    Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy'])->name('admin.transaksi.destroy');

    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('admin.pembayaran.index');
    Route::post('/pembayaran', [PembayaranController::class, 'store'])->name('admin.pembayaran.store');
    Route::put('/pembayaran/{pembayaran}', [PembayaranController::class, 'update'])->name('admin.pembayaran.update');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
    Route::get('/laporan/export', [LaporanController::class, 'exportPdf'])->name('admin.laporan.export');

    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('admin.pengaturan.index');
    Route::put('/pengaturan/profile', [PengaturanController::class, 'updateProfile'])->name('admin.pengaturan.profile');
    Route::put('/pengaturan/password', [PengaturanController::class, 'updatePassword'])->name('admin.pengaturan.password');
    Route::post('/pengaturan/user', [PengaturanController::class, 'createUser'])->name('admin.pengaturan.createUser');
    Route::delete('/pengaturan/user/{user}', [PengaturanController::class, 'deleteUser'])->name('admin.pengaturan.deleteUser');
});

// User routes
Route::prefix('user')->middleware(['auth', 'user'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/pembayaran', [UserPembayaranController::class, 'index'])->name('user.pembayaran.index');
});

// Default redirect
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
});