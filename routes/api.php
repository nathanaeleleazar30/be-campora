<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FotoBarangController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\KetersediaanBarangController;
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
Route::get('/ketersediaan/today', [KetersediaanBarangController::class, 'checkToday']);


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
    Route::get('/ketersediaan',              [KetersediaanBarangController::class, 'index']);
    Route::post('/ketersediaan',             [KetersediaanBarangController::class, 'store']);
    Route::get('/ketersediaan/check',        [KetersediaanBarangController::class, 'checkAvailability']);
    Route::put('/ketersediaan/{ketersediaan}',[KetersediaanBarangController::class, 'update']);
    Route::delete('/ketersediaan/{ketersediaan}', [KetersediaanBarangController::class, 'destroy']);

    // FAQ
    Route::post('/faqs',          [FaqController::class, 'store']);
    Route::put('/faqs/{faq}',     [FaqController::class, 'update']);
    Route::delete('/faqs/{faq}',  [FaqController::class, 'destroy']);

    // Testimoni moderation
    Route::get('/testimonis',                        [TestimoniController::class, 'adminIndex']);
    Route::post('/testimonis',                       [TestimoniController::class, 'store']);
    Route::put('/testimonis/{testimoni}',            [TestimoniController::class, 'update']);
    Route::post('/testimonis/{testimoni}/update',    [TestimoniController::class, 'update']); // FormData upload (foto)
    Route::patch('/testimonis/{testimoni}/approve',  [TestimoniController::class, 'approve']);
    Route::patch('/testimonis/{testimoni}/unapprove',[TestimoniController::class, 'unapprove']);
    Route::delete('/testimonis/{testimoni}',         [TestimoniController::class, 'destroy']);

    // Paket
    Route::post('/pakets',               [PaketController::class, 'store']);
    Route::put('/pakets/{paket}',        [PaketController::class, 'update']);
    Route::delete('/pakets/{paket}',     [PaketController::class, 'destroy']);
});
