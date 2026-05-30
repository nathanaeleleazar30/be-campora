<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KetersediaanBarang;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class KetersediaanBarangController extends Controller
{
    /**
     * Return real-time stock availability for ALL active barangs for today.
     * Used by the customer frontend to hide out-of-stock items.
     *
     * GET /api/ketersediaan/today
     */
    public function checkToday(): JsonResponse
    {
        $today = Carbon::today()->toDateString();

        $barangs = Barang::where('is_aktif', true)->get();

        $result = $barangs->map(function (Barang $barang) use ($today) {
            $stokDisewa = KetersediaanBarang::where('id_barang', $barang->id_barang)
                ->where('tanggal_mulai', '<=', $today)
                ->where('tanggal_selesai', '>=', $today)
                ->sum('stok_disewa');

            $stokTersedia = max(0, $barang->stok_total - $stokDisewa);

            return [
                'id_barang'     => $barang->id_barang,
                'stok_tersedia' => $stokTersedia,
                'tersedia'      => $stokTersedia > 0,
            ];
        });

        return response()->json($result);
    }

    /**
     * Display a listing of ketersediaan records.
     * Optionally filter by id_barang.
     *
     * GET /api/ketersediaan
     */
    public function index(Request $request): JsonResponse
    {
        $query = KetersediaanBarang::with(['barang', 'admin']);

        if ($request->filled('id_barang')) {
            $query->where('id_barang', $request->id_barang);
        }

        return response()->json($query->orderBy('tanggal_mulai')->paginate(20));
    }

    /**
     * Store a new ketersediaan (rental booking block) record.
     *
     * POST /api/ketersediaan
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id_barang'      => 'required|exists:barangs,id_barang',
            'id_admin'       => 'required|exists:admins,id_admin',
            'tanggal_mulai'  => 'required|date|before_or_equal:tanggal_selesai',
            'tanggal_selesai'=> 'required|date|after_or_equal:tanggal_mulai',
            'stok_disewa'    => 'required|integer|min:1',
            'catatan'        => 'nullable|string',
        ]);

        // Check stock availability before creating the record
        $availabilityResult = $this->getAvailableStock(
            $validated['id_barang'],
            $validated['tanggal_mulai'],
            $validated['tanggal_selesai']
        );

        if ($validated['stok_disewa'] > $availabilityResult['stok_tersedia']) {
            return response()->json([
                'message' => 'Stok tidak mencukupi untuk rentang tanggal yang dipilih.',
                'data'    => $availabilityResult,
            ], 422);
        }

        $ketersediaan = KetersediaanBarang::create($validated);

        return response()->json([
            'message' => 'Ketersediaan berhasil dicatat.',
            'data'    => $ketersediaan->load(['barang', 'admin']),
        ], 201);
    }

    /**
     * Check real-time stock availability for a given barang and date range.
     *
     * GET /api/ketersediaan/check?id_barang=1&tanggal_mulai=2025-07-01&tanggal_selesai=2025-07-05
     */
    public function checkAvailability(Request $request): JsonResponse
    {
        $request->validate([
            'id_barang'      => 'required|exists:barangs,id_barang',
            'tanggal_mulai'  => 'required|date|before_or_equal:tanggal_selesai',
            'tanggal_selesai'=> 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $result = $this->getAvailableStock(
            $request->id_barang,
            $request->tanggal_mulai,
            $request->tanggal_selesai
        );

        return response()->json($result);
    }

    /**
     * Update an existing ketersediaan record.
     *
     * PUT /api/ketersediaan/{id}
     */
    public function update(Request $request, KetersediaanBarang $ketersediaan): JsonResponse
    {
        $validated = $request->validate([
            'tanggal_mulai'  => 'sometimes|date|before_or_equal:tanggal_selesai',
            'tanggal_selesai'=> 'sometimes|date|after_or_equal:tanggal_mulai',
            'stok_disewa'    => 'sometimes|integer|min:1',
            'catatan'        => 'nullable|string',
        ]);

        $ketersediaan->update($validated);

        return response()->json([
            'message' => 'Ketersediaan berhasil diperbarui.',
            'data'    => $ketersediaan->fresh(['barang', 'admin']),
        ]);
    }

    /**
     * Remove the specified ketersediaan record.
     *
     * DELETE /api/ketersediaan/{id}
     */
    public function destroy(KetersediaanBarang $ketersediaan): JsonResponse
    {
        $ketersediaan->delete();

        return response()->json([
            'message' => 'Catatan ketersediaan berhasil dihapus.',
        ]);
    }

    // ----------------------------------------------------------------
    // Private Helpers
    // ----------------------------------------------------------------

    /**
     * Calculate how many units of a barang are still available
     * during the requested date range by summing conflicting bookings.
     */
    private function getAvailableStock(int $idBarang, string $mulai, string $selesai): array
    {
        $barang = Barang::findOrFail($idBarang);

        // Sum stok_disewa for all overlapping ketersediaan records
        $stokDisewa = KetersediaanBarang::where('id_barang', $idBarang)
            ->where('tanggal_mulai', '<=', $selesai)
            ->where('tanggal_selesai', '>=', $mulai)
            ->sum('stok_disewa');

        $stokTersedia = $barang->stok_total - $stokDisewa;

        return [
            'id_barang'      => $idBarang,
            'nama_barang'    => $barang->nama_barang,
            'stok_total'     => $barang->stok_total,
            'stok_disewa'    => (int) $stokDisewa,
            'stok_tersedia'  => max(0, $stokTersedia),
            'tersedia'       => $stokTersedia > 0,
            'tanggal_mulai'  => $mulai,
            'tanggal_selesai'=> $selesai,
        ];
    }
}
