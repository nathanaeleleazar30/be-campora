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
    public function dashboard(): JsonResponse
    {
        $today = Carbon::today()->toDateString();

        $totalBarang   = Barang::count();
        $totalKategori = KategoriBarang::count();

        // Total unit barang yang sedang disewa hari ini
        $sewaHariIni = KetersediaanBarang::whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->sum('stok_disewa');

        // Barang tersedia = barang yg stoknya belum habis di-booking hari ini
        $barangs = Barang::all();
        $barangTersedia = 0;
        foreach ($barangs as $barang) {
            $stokDisewa = KetersediaanBarang::where('id_barang', $barang->id_barang)
                ->whereDate('tanggal_mulai', '<=', $today)
                ->whereDate('tanggal_selesai', '>=', $today)
                ->sum('stok_disewa');
            if ($barang->stok_total - $stokDisewa > 0) {
                $barangTersedia++;
            }
        }

        return response()->json([
            'total_barang'   => $totalBarang,
            'barang_aktif'   => $barangTersedia,
            'total_kategori' => $totalKategori,
            'sewa_hari_ini'  => $sewaHariIni,
        ]);
    }

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
