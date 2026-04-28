<?php

namespace App\Http\Controllers;

use App\Models\FotoBarang;
use App\Models\Barang;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoBarangController extends Controller
{
    /**
     * Upload and attach a new photo to a barang.
     *
     * POST /api/barangs/{barang}/fotos
     */
    public function store(Request $request, Barang $barang): JsonResponse
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,webp|max:2048',
        ]);

        $path = $request->file('foto')->store("fotos/{$barang->id_barang}", 'public');

        $foto = FotoBarang::create([
            'id_barang' => $barang->id_barang,
            'url_foto'  => Storage::url($path),
        ]);

        return response()->json([
            'message' => 'Foto berhasil diupload.',
            'data'    => $foto,
        ], 201);
    }

    /**
     * Delete a photo by its ID.
     *
     * DELETE /api/fotos/{foto}
     */
    public function destroy(FotoBarang $fotoBarang): JsonResponse
    {
        // Optionally delete the file from disk
        $relativePath = str_replace('/storage/', '', $fotoBarang->url_foto);
        Storage::disk('public')->delete($relativePath);

        $fotoBarang->delete();

        return response()->json(['message' => 'Foto berhasil dihapus.']);
    }
}
