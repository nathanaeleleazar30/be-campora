<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\KetersediaanBarang;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class InventoryController extends Controller
{
    /**
     * Admin Inventory Dashboard: summary stats.
     *
     * GET /api/admin/inventory/dashboard
     */
    public function dashboard(): JsonResponse
    {
        $totalBarang   = Barang::count();
        $activeBarang  = Barang::where('is_aktif', true)->count();
        $totalKategori = KategoriBarang::count();

        // Items currently being rented today
        $today = Carbon::today()->toDateString();
        $sewaHariIni = KetersediaanBarang::where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->count();

        return response()->json([
            'total_barang'    => $totalBarang,
            'barang_aktif'    => $activeBarang,
            'barang_nonaktif' => $totalBarang - $activeBarang,
            'total_kategori'  => $totalKategori,
            'sewa_hari_ini'   => $sewaHariIni,
        ]);
    }

    /**
     * List items with low stock (stok_total below a threshold).
     *
     * GET /api/admin/inventory/low-stock?threshold=5
     */
    public function lowStock(Request $request): JsonResponse
    {
        $threshold = $request->integer('threshold', 5);

        $items = Barang::with('kategori')
            ->where('is_aktif', true)
            ->where('stok_total', '<=', $threshold)
            ->orderBy('stok_total')
            ->get();

        return response()->json([
            'threshold' => $threshold,
            'count'     => $items->count(),
            'data'      => $items,
        ]);
    }

    /**
     * Restock a barang by incrementing its stok_total.
     *
     * PATCH /api/admin/inventory/{barang}/restock
     */
    public function restock(Request $request, Barang $barang): JsonResponse
    {
        $validated = $request->validate([
            'tambah_stok' => 'required|integer|min:1',
        ]);

        $barang->increment('stok_total', $validated['tambah_stok']);

        return response()->json([
            'message'        => "Stok berhasil ditambahkan.",
            'nama_barang'    => $barang->nama_barang,
            'stok_sebelumnya'=> $barang->stok_total - $validated['tambah_stok'],
            'stok_sekarang'  => $barang->fresh()->stok_total,
        ]);
    }
}
