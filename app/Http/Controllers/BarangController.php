<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Barang::with(['kategori', 'fotos']);

        if ($request->filled('id_kategori')) {
            $query->where('id_kategori', $request->id_kategori);
        }

        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        $barangs = $query->paginate($request->integer('per_page', 12));

        return response()->json($barangs);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id_kategori'   => 'required|exists:kategori_barangs,id_kategori',
            'nama_barang'   => 'required|string|max:200',
            'merk'          => 'nullable|string|max:100',
            'spesifikasi'   => 'nullable|string',
            'harga_per_hari'=> 'required|numeric|min:0',
            'stok_total'    => 'required|integer|min:0',
        ]);

        $barang = Barang::create($validated);

        return response()->json([
            'message' => 'Barang berhasil ditambahkan.',
            'data'    => $barang->load('kategori'),
        ], 201);
    }

    public function show(Barang $barang): JsonResponse
    {
        return response()->json(
            $barang->load(['kategori', 'fotos'])
        );
    }

    public function update(Request $request, Barang $barang): JsonResponse
    {
        $validated = $request->validate([
            'id_kategori'   => 'sometimes|exists:kategori_barangs,id_kategori',
            'nama_barang'   => 'sometimes|string|max:200',
            'merk'          => 'nullable|string|max:100',
            'spesifikasi'   => 'nullable|string',
            'harga_per_hari'=> 'sometimes|numeric|min:0',
            'stok_total'    => 'sometimes|integer|min:0',
        ]);

        $barang->update($validated);

        return response()->json([
            'message' => 'Barang berhasil diperbarui.',
            'data'    => $barang->fresh(['kategori', 'fotos']),
        ]);
    }

    public function destroy(Barang $barang): JsonResponse
    {
        $barang->delete();

        return response()->json([
            'message' => 'Barang berhasil dihapus.',
        ]);
    }
}
