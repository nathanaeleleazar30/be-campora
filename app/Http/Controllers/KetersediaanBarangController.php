<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KetersediaanBarang;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class KetersediaanBarangController extends Controller
{
    public function checkToday(): JsonResponse
    {
        $today = Carbon::today()->toDateString();

        $barangs = Barang::where('is_aktif', true)->get();

        $result = $barangs->map(function (Barang $barang) use ($today) {
            $stokDisewa = KetersediaanBarang::where('id_barang', $barang->id_barang)
                ->whereDate('tanggal_mulai', '<=', $today)
                ->whereDate('tanggal_selesai', '>=', $today)
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

    public function index(Request $request): JsonResponse
    {
        $query = KetersediaanBarang::with(['barang', 'admin']);

        if ($request->filled('id_barang')) {
            $query->where('id_barang', $request->id_barang);
        }

        return response()->json($query->orderBy('tanggal_mulai')->paginate(20));
    }

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

    public function syncDates(Request $request): JsonResponse
    {
        $request->validate([
            'id_barang' => 'required|exists:barangs,id_barang',
            'id_admin'  => 'required|exists:admins,id_admin',
            'changes'   => 'required|array',
            'changes.*.date'   => 'required|date',
            'changes.*.status' => 'required|in:merah,hijau',
        ]);

        $idBarang = $request->id_barang;
        $idAdmin = $request->id_admin;

        foreach ($request->changes as $change) {
            $date = $change['date'];
            $status = $change['status'];

            if ($status === 'merah') {
                $exists = KetersediaanBarang::where('id_barang', $idBarang)
                            ->whereDate('tanggal_mulai', '<=', $date)
                            ->whereDate('tanggal_selesai', '>=', $date)
                            ->exists();
                
                if (!$exists) {
                    KetersediaanBarang::create([
                        'id_barang' => $idBarang,
                        'id_admin'  => $idAdmin,
                        'tanggal_mulai' => $date,
                        'tanggal_selesai' => $date,
                        'stok_disewa' => 1,
                        'catatan' => 'Manual block from calendar'
                    ]);
                }
            } else if ($status === 'hijau') {
                KetersediaanBarang::where('id_barang', $idBarang)
                            ->whereDate('tanggal_mulai', '<=', $date)
                            ->whereDate('tanggal_selesai', '>=', $date)
                            ->delete();
            }
        }

        return response()->json([
            'message' => 'Status ketersediaan berhasil disinkronkan.',
        ]);
    }

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

    public function destroy(KetersediaanBarang $ketersediaan): JsonResponse
    {
        $ketersediaan->delete();

        return response()->json([
            'message' => 'Catatan ketersediaan berhasil dihapus.',
        ]);
    }

    private function getAvailableStock(int $idBarang, string $mulai, string $selesai): array
    {
        $barang = Barang::findOrFail($idBarang);

        $stokDisewa = KetersediaanBarang::where('id_barang', $idBarang)
            ->whereDate('tanggal_mulai', '<=', $selesai)
            ->whereDate('tanggal_selesai', '>=', $mulai)
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
