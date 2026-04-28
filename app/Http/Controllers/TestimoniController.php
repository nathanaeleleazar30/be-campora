<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    /**
     * List all approved testimonials (public).
     *
     * GET /api/testimonis
     */
    public function index(): JsonResponse
    {
        $testimonis = Testimoni::orderByDesc('created_at')->paginate(10);

        return response()->json($testimonis);
    }

    /**
     * Store a new testimonial (submitted by customer via form).
     *
     * POST /api/testimonis
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_customer'  => 'required|string|max:150',
            'foto_customer'  => 'nullable|image|mimes:jpeg,png,webp|max:1024',
            'rating'         => 'required|integer|min:1|max:5',
            'isi_review'     => 'required|string',
        ]);

        if ($request->hasFile('foto_customer')) {
            $path = $request->file('foto_customer')->store('testimonis', 'public');
            $validated['foto_customer'] = \Illuminate\Support\Facades\Storage::url($path);
        }

        $testimoni = Testimoni::create($validated);

        return response()->json(['message' => 'Testimoni berhasil dikirim. Terima kasih!', 'data' => $testimoni], 201);
    }

    /**
     * Update a testimonial (admin moderation).
     *
     * PUT /api/testimonis/{id}
     */
    public function update(Request $request, Testimoni $testimoni): JsonResponse
    {
        $validated = $request->validate([
            'nama_customer' => 'sometimes|string|max:150',
            'rating'        => 'sometimes|integer|min:1|max:5',
            'isi_review'    => 'sometimes|string',
            'id_admin'      => 'nullable|exists:admins,id_admin',
        ]);

        $testimoni->update($validated);

        return response()->json(['message' => 'Testimoni berhasil diperbarui.', 'data' => $testimoni->fresh()]);
    }

    /**
     * Delete a testimonial.
     *
     * DELETE /api/testimonis/{id}
     */
    public function destroy(Testimoni $testimoni): JsonResponse
    {
        $testimoni->delete();

        return response()->json(['message' => 'Testimoni berhasil dihapus.']);
    }
}
