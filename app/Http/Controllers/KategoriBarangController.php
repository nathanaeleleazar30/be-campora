<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriBarangController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(KategoriBarang::withCount('barangs')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:150|unique:kategori_barangs',
            'slug'          => 'nullable|string|max:150|unique:kategori_barangs',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['nama_kategori']);

        $kategori = KategoriBarang::create($validated);

        return response()->json(['message' => 'Kategori berhasil ditambahkan.', 'data' => $kategori], 201);
    }

    public function update(Request $request, KategoriBarang $kategoriBarang): JsonResponse
    {
        $validated = $request->validate([
            'nama_kategori' => 'sometimes|string|max:150|unique:kategori_barangs,nama_kategori,' . $kategoriBarang->id_kategori . ',id_kategori',
            'slug'          => 'sometimes|string|max:150|unique:kategori_barangs,slug,' . $kategoriBarang->id_kategori . ',id_kategori',
        ]);

        if (isset($validated['nama_kategori']) && !isset($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['nama_kategori']);
        }

        $kategoriBarang->update($validated);

        return response()->json(['message' => 'Kategori berhasil diperbarui.', 'data' => $kategoriBarang->fresh()]);
    }

    public function destroy(KategoriBarang $kategoriBarang): JsonResponse
    {
        $kategoriBarang->delete();

        return response()->json(['message' => 'Kategori berhasil dihapus.']);
    }
}
