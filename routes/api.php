<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FotoBarangController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\KetersediaanController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\TestimoniController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ── Auth ─────────────────────────────────────────────────────────────
Route::post('/admin/login', [AdminController::class, 'login']);

// ── Public ───────────────────────────────────────────────────────────
Route::get('/barangs',       [BarangController::class, 'index']);
Route::get('/barangs/{barang}', [BarangController::class, 'show']);
Route::get('/kategori',      [KategoriBarangController::class, 'index']);
Route::get('/faqs',          [FaqController::class, 'index']);
Route::get('/testimonis',    [TestimoniController::class, 'index']);
Route::post('/testimonis',   [TestimoniController::class, 'store']);
Route::get('/pakets',        [PaketController::class, 'index']);

// ── Admin (protected) ───────────────────────────────────────────────
Route::prefix('admin')->group(function () {
    // Dashboard
    Route::get('/inventory/dashboard', [InventoryController::class, 'dashboard']);
    Route::get('/inventory/low-stock', [InventoryController::class, 'lowStock']);
    Route::patch('/inventory/{barang}/restock', [InventoryController::class, 'restock']);

    // Barang CRUD
    Route::post('/barangs',            [BarangController::class, 'store']);
    Route::put('/barangs/{barang}',    [BarangController::class, 'update']);
    Route::delete('/barangs/{barang}', [BarangController::class, 'destroy']);

    // Foto
    Route::post('/barangs/{barang}/fotos', [FotoBarangController::class, 'store']);
    Route::delete('/fotos/{fotoBarang}',   [FotoBarangController::class, 'destroy']);

    // Kategori
    Route::post('/kategori',               [KategoriBarangController::class, 'store']);
    Route::put('/kategori/{kategoriBarang}',[KategoriBarangController::class, 'update']);
    Route::delete('/kategori/{kategoriBarang}', [KategoriBarangController::class, 'destroy']);

    // Ketersediaan
    Route::get('/ketersediaan',              [KetersediaanController::class, 'index']);
    Route::post('/ketersediaan',             [KetersediaanController::class, 'store']);
    Route::get('/ketersediaan/check',        [KetersediaanController::class, 'checkAvailability']);
    Route::put('/ketersediaan/{ketersediaan}',[KetersediaanController::class, 'update']);
    Route::delete('/ketersediaan/{ketersediaan}', [KetersediaanController::class, 'destroy']);

    // FAQ
    Route::post('/faqs',          [FaqController::class, 'store']);
    Route::put('/faqs/{faq}',     [FaqController::class, 'update']);
    Route::delete('/faqs/{faq}',  [FaqController::class, 'destroy']);

    // Testimoni moderation
    Route::put('/testimonis/{testimoni}',    [TestimoniController::class, 'update']);
    Route::delete('/testimonis/{testimoni}', [TestimoniController::class, 'destroy']);
    Route::post('/testimonis',               [TestimoniController::class, 'store']);

    // Paket
    Route::post('/pakets',               [PaketController::class, 'store']);
    Route::put('/pakets/{paket}',        [PaketController::class, 'update']);
    Route::delete('/pakets/{paket}',     [PaketController::class, 'destroy']);
});
