<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaketController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Paket::where('is_aktif', true)->orderByDesc('is_featured')->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:200',
            'deskripsi'  => 'nullable|string',
            'items'      => 'required|array|min:1',
            'items.*'    => 'string',
            'harga'      => 'required|numeric|min:0',
            'is_featured'=> 'boolean',
            'gambar'     => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('pakets', 'public');
            $validated['gambar'] = Storage::url($path);
        }

        $paket = Paket::create($validated);

        return response()->json(['message' => 'Paket berhasil ditambahkan.', 'data' => $paket], 201);
    }

    public function update(Request $request, Paket $paket): JsonResponse
    {
        $validated = $request->validate([
            'nama_paket' => 'sometimes|string|max:200',
            'deskripsi'  => 'nullable|string',
            'items'      => 'sometimes|array|min:1',
            'items.*'    => 'string',
            'harga'      => 'sometimes|numeric|min:0',
            'is_featured'=> 'boolean',
            'is_aktif'   => 'boolean',
        ]);

        $paket->update($validated);

        return response()->json(['message' => 'Paket berhasil diperbarui.', 'data' => $paket->fresh()]);
    }

    public function destroy(Paket $paket): JsonResponse
    {
        $paket->update(['is_aktif' => false]);

        return response()->json(['message' => 'Paket berhasil dinonaktifkan.']);
    }
}
