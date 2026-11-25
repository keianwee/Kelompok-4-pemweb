<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Guest\GuestController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\BookingManagementController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Api\RoomApiController;

// Halaman Publik (Front Office)
Route::get('/', [GuestController::class, 'home'])->name('home');

// Custom REST API (Tanpa perlu login)
Route::prefix('api')->group(function () {
    Route::get('/rooms/availability', [RoomApiController::class, 'availability']);
    Route::get('/rooms/popular', [RoomApiController::class, 'popular']);
});

// Autentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Download Invoice PDF (Bisa diakses Tamu pemilik booking atau Admin)
Route::get('/bookings/{booking}/invoice', [GuestController::class, 'downloadInvoice'])
    ->middleware('auth')
    ->name('bookings.invoice');

// Area Tamu / Pengunjung
Route::middleware(['auth', 'role:guest'])->prefix('guest')->name('guest.')->group(function () {
    Route::get('/bookings/create', [GuestController::class, 'createBooking'])->name('bookings.create');
    Route::post('/bookings', [GuestController::class, 'storeBooking'])->name('bookings.store');
    Route::get('/my-bookings', [GuestController::class, 'myBookings'])->name('bookings.index');
});

// Area Manajemen / Admin (Back Office)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/room-types', RoomTypeController::class)->except(['show']);
    Route::resource('/rooms', RoomController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::get('/bookings', [BookingManagementController::class, 'index'])->name('bookings.index');
    Route::patch('/bookings/{booking}/status', [BookingManagementController::class, 'updateStatus'])->name('bookings.status');
    Route::get('/bookings/export-excel', [BookingManagementController::class, 'exportExcel'])->name('bookings.export-excel');
    Route::get('/bookings/export-pdf', [BookingManagementController::class, 'exportPdf'])->name('bookings.export-pdf');

    // Fitur Backup Otomatis & Restore Data
    Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
    Route::get('/backup/download', [BackupController::class, 'downloadNow'])->name('backup.download');
    Route::get('/backup/file/{filename}', [BackupController::class, 'downloadStored'])->name('backup.file');
    Route::post('/backup/import', [BackupController::class, 'import'])->name('backup.import');
});