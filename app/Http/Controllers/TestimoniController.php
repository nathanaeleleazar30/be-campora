<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    public function index(): JsonResponse
    {
        $testimonis = Testimoni::where('is_approved', true)
            ->orderByDesc('created_at')
            ->paginate(20);

        return response()->json($testimonis);
    }

    public function adminIndex(): JsonResponse
    {
        $testimonis = Testimoni::orderByDesc('created_at')->paginate(50);

        return response()->json($testimonis);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_customer'  => 'required|string|max:150',
            'foto_customer'  => 'nullable|image|mimes:jpeg,png,webp|max:1024',
            'rating'         => 'required|integer|min:0|max:5',
            'isi_review'     => 'required|string',
            'produk_disewa'  => 'nullable|string|max:200',
            'kegiatan'       => 'nullable|string|max:200',
            'is_approved'    => 'sometimes|boolean',
        ]);

        if ($request->hasFile('foto_customer')) {
            $path = $request->file('foto_customer')->store('testimonis', 'public');
            $validated['foto_customer'] = \Illuminate\Support\Facades\Storage::url($path);
        }

        if (!isset($validated['is_approved'])) {
            $validated['is_approved'] = false;
        }

        $testimoni = Testimoni::create($validated);

        return response()->json(['message' => 'Testimoni berhasil dikirim. Terima kasih!', 'data' => $testimoni], 201);
    }

    public function update(Request $request, Testimoni $testimoni): JsonResponse
    {
        $validated = $request->validate([
            'nama_customer' => 'sometimes|string|max:150',
            'foto_customer' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'rating'        => 'sometimes|integer|min:0|max:5',
            'isi_review'    => 'sometimes|string',
            'produk_disewa' => 'nullable|string|max:200',
            'kegiatan'      => 'nullable|string|max:200',
            'is_approved'   => 'sometimes|boolean',
            'id_admin'      => 'nullable|exists:admins,id_admin',
        ]);

        if ($request->hasFile('foto_customer')) {
            if ($testimoni->foto_customer) {
                $oldPath = str_replace('/storage/', '', parse_url($testimoni->foto_customer, PHP_URL_PATH));
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('foto_customer')->store('testimonis', 'public');
            $validated['foto_customer'] = \Illuminate\Support\Facades\Storage::url($path);
        } elseif ($request->input('remove_foto') === '1') {
            if ($testimoni->foto_customer) {
                $oldPath = str_replace('/storage/', '', parse_url($testimoni->foto_customer, PHP_URL_PATH));
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            }
            $validated['foto_customer'] = null;
        }

        $testimoni->update($validated);

        return response()->json(['message' => 'Testimoni berhasil diperbarui.', 'data' => $testimoni->fresh()]);
    }

    public function approve(Testimoni $testimoni): JsonResponse
    {
        $testimoni->update(['is_approved' => true]);

        return response()->json(['message' => 'Testimoni disetujui dan akan tampil di frontend.', 'data' => $testimoni->fresh()]);
    }

    public function unapprove(Testimoni $testimoni): JsonResponse
    {
        $testimoni->update(['is_approved' => false]);

        return response()->json(['message' => 'Testimoni disembunyikan dari frontend.', 'data' => $testimoni->fresh()]);
    }

    public function destroy(Testimoni $testimoni): JsonResponse
    {
        $testimoni->delete();

        return response()->json(['message' => 'Testimoni berhasil dihapus.']);
    }
}
