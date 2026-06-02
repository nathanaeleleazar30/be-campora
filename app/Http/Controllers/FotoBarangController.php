<?php

namespace App\Http\Controllers;

use App\Models\FotoBarang;
use App\Models\Barang;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoBarangController extends Controller
{
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

    public function destroy(FotoBarang $fotoBarang): JsonResponse
    {
        $relativePath = str_replace('/storage/', '', $fotoBarang->url_foto);
        Storage::disk('public')->delete($relativePath);

        $fotoBarang->delete();

        return response()->json(['message' => 'Foto berhasil dihapus.']);
    }
}
