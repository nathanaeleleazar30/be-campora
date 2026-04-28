<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a paginated listing of active items.
     * Supports filtering by id_kategori and search by nama_barang.
     *
     * GET /api/barangs
     */
    public function index(Request $request): JsonResponse
    {
        $query = Barang::with(['kategori', 'fotos'])
            ->where('is_aktif', true);

        // Filter by category
        if ($request->filled('id_kategori')) {
            $query->where('id_kategori', $request->id_kategori);
        }

        // Search by name
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        $barangs = $query->paginate($request->integer('per_page', 12));

        return response()->json($barangs);
    }

    /**
     * Store a newly created barang in storage.
     *
     * POST /api/barangs
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id_kategori'   => 'required|exists:kategori_barangs,id_kategori',
            'nama_barang'   => 'required|string|max:200',
            'merk'          => 'nullable|string|max:100',
            'spesifikasi'   => 'nullable|string',
            'harga_per_hari'=> 'required|numeric|min:0',
            'stok_total'    => 'required|integer|min:0',
            'is_aktif'      => 'boolean',
        ]);

        $barang = Barang::create($validated);

        return response()->json([
            'message' => 'Barang berhasil ditambahkan.',
            'data'    => $barang->load('kategori'),
        ], 201);
    }

    /**
     * Display the specified barang with its photos and category.
     *
     * GET /api/barangs/{id}
     */
    public function show(Barang $barang): JsonResponse
    {
        return response()->json(
            $barang->load(['kategori', 'fotos'])
        );
    }

    /**
     * Update the specified barang in storage.
     *
     * PUT /api/barangs/{id}
     */
    public function update(Request $request, Barang $barang): JsonResponse
    {
        $validated = $request->validate([
            'id_kategori'   => 'sometimes|exists:kategori_barangs,id_kategori',
            'nama_barang'   => 'sometimes|string|max:200',
            'merk'          => 'nullable|string|max:100',
            'spesifikasi'   => 'nullable|string',
            'harga_per_hari'=> 'sometimes|numeric|min:0',
            'stok_total'    => 'sometimes|integer|min:0',
            'is_aktif'      => 'boolean',
        ]);

        $barang->update($validated);

        return response()->json([
            'message' => 'Barang berhasil diperbarui.',
            'data'    => $barang->fresh(['kategori', 'fotos']),
        ]);
    }

    /**
     * Soft-deactivate (or permanently delete) the specified barang.
     *
     * DELETE /api/barangs/{id}
     */
    public function destroy(Barang $barang): JsonResponse
    {
        // Use soft-deactivation to preserve availability records
        $barang->update(['is_aktif' => false]);

        return response()->json([
            'message' => 'Barang berhasil dinonaktifkan.',
        ]);
    }
}
