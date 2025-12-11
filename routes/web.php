<?php

use Illuminate\Support\Facades\Route;

// 1. IMPOR SEMUA CONTROLLER DI BAGIAN PALING ATAS
// Ini memastikan Laravel dapat menemukan kelas-kelas ini di semua rute di bawah.
use App\Http\Controllers\AdminController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\SessionController;


// ----------------------------------------------------
// RUTE UTAMA (LOGIN)
// ----------------------------------------------------

// Tampil Form Login
Route::get('/', [SessionController::class, 'index']);

// Proses Login
Route::post('/', [SessionController::class, 'login']);


// ----------------------------------------------------
// ADMIN ROUTES (WAJIB DILINDUNGI DENGAN MIDDLEWARE 'AUTH' DI MASA DEPAN)
// ----------------------------------------------------

// Dashboard Admin
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/user', [AdminController::class, 'user']);
// Rute untuk halaman antrian admin
Route::get('/admin/navQueue', [QueueController::class, 'navQueue']);
Route::post('/admin/navQueue/next', [QueueController::class, 'callNext'])->name('queue.callNext');
Route::get('/admin/queue/index', [QueueController::class, 'index']);
Route::get('admin/user/getQueue', [QueueController::class, 'getQueue']);
Route::get('admin/user/listQueue', [QueueController::class, 'listQueue']);

// USER ROUTES untuk mengambil dan melihat antrian
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/get-queue', [QueueController::class, 'getQueue'])->name('get-queue');
    Route::post('/get-queue', [QueueController::class, 'storeQueue'])->name('store-queue');
    Route::get('/list-queue', [QueueController::class, 'listQueue'])->name('list-queue');
});

// CRUD Routes untuk Queue Management
Route::prefix('admin/queue')->group(function () {
    Route::get('/', [QueueController::class, 'index'])->name('queue.index');
    Route::get('/create', [QueueController::class, 'create'])->name('queue.create');
    Route::post('/', [QueueController::class, 'store'])->name('queue.store');
    Route::get('/{queue}/edit', [QueueController::class, 'edit'])->name('queue.edit');
    Route::put('/{queue}', [QueueController::class, 'update'])->name('queue.update');
    Route::delete('/{queue}', [QueueController::class, 'destroy'])->name('queue.destroy');
});
// Proses Logout (Saat ini menggunakan GET seperti permintaan Anda)
Route::get('/logout', [SessionController::class, 'logout']);

// Pastikan Anda telah menambahkan method 'logout' di dalam SessionController!