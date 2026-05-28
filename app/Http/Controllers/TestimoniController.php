<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    /**
     * List all APPROVED testimonials (public — frontend customer).
     *
     * GET /api/testimonis
     */
    public function index(): JsonResponse
    {
        $testimonis = Testimoni::where('is_approved', true)
            ->orderByDesc('created_at')
            ->paginate(20);

        return response()->json($testimonis);
    }

    /**
     * List ALL testimonials regardless of approval (admin moderation panel).
     *
     * GET /api/admin/testimonis
     */
    public function adminIndex(): JsonResponse
    {
        $testimonis = Testimoni::orderByDesc('created_at')->paginate(50);

        return response()->json($testimonis);
    }

    /**
     * Store a new testimonial.
     * - When called by customer (POST /api/testimonis): is_approved defaults to false (pending)
     * - When called by admin (POST /api/admin/testimonis): can pass is_approved = true directly
     *
     * POST /api/testimonis  |  POST /api/admin/testimonis
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_customer'  => 'required|string|max:150',
            'foto_customer'  => 'nullable|image|mimes:jpeg,png,webp|max:1024',
            'rating'         => 'required|integer|min:1|max:5',
            'isi_review'     => 'required|string',
            'produk_disewa'  => 'nullable|string|max:200',
            'kegiatan'       => 'nullable|string|max:200',
            'is_approved'    => 'sometimes|boolean',
        ]);

        if ($request->hasFile('foto_customer')) {
            $path = $request->file('foto_customer')->store('testimonis', 'public');
            $validated['foto_customer'] = \Illuminate\Support\Facades\Storage::url($path);
        }

        // Customers always start as pending; admin can override
        if (!isset($validated['is_approved'])) {
            $validated['is_approved'] = false;
        }

        $testimoni = Testimoni::create($validated);

        return response()->json(['message' => 'Testimoni berhasil dikirim. Terima kasih!', 'data' => $testimoni], 201);
    }

    /**
     * Update a testimonial (admin moderation).
     *
     * PUT /api/admin/testimonis/{id}
     */
    public function update(Request $request, Testimoni $testimoni): JsonResponse
    {
        $validated = $request->validate([
            'nama_customer' => 'sometimes|string|max:150',
            'rating'        => 'sometimes|integer|min:1|max:5',
            'isi_review'    => 'sometimes|string',
            'produk_disewa' => 'nullable|string|max:200',
            'kegiatan'      => 'nullable|string|max:200',
            'is_approved'   => 'sometimes|boolean',
            'id_admin'      => 'nullable|exists:admins,id_admin',
        ]);

        $testimoni->update($validated);

        return response()->json(['message' => 'Testimoni berhasil diperbarui.', 'data' => $testimoni->fresh()]);
    }

    /**
     * Approve a testimonial (show on frontend).
     *
     * PATCH /api/admin/testimonis/{id}/approve
     */
    public function approve(Testimoni $testimoni): JsonResponse
    {
        $testimoni->update(['is_approved' => true]);

        return response()->json(['message' => 'Testimoni disetujui dan akan tampil di frontend.', 'data' => $testimoni->fresh()]);
    }

    /**
     * Unapprove / hide a testimonial from frontend.
     *
     * PATCH /api/admin/testimonis/{id}/unapprove
     */
    public function unapprove(Testimoni $testimoni): JsonResponse
    {
        $testimoni->update(['is_approved' => false]);

        return response()->json(['message' => 'Testimoni disembunyikan dari frontend.', 'data' => $testimoni->fresh()]);
    }

    /**
     * Delete a testimonial.
     *
     * DELETE /api/admin/testimonis/{id}
     */
    public function destroy(Testimoni $testimoni): JsonResponse
    {
        $testimoni->delete();

        return response()->json(['message' => 'Testimoni berhasil dihapus.']);
    }
}
