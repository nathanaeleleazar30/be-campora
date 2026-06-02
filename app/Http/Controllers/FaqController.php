<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Faq::orderBy('created_at')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban'    => 'required|string',
            'id_admin'   => 'required|exists:admins,id_admin',
        ]);

        $faq = Faq::create($validated);

        return response()->json(['message' => 'FAQ berhasil ditambahkan.', 'data' => $faq], 201);
    }

    public function update(Request $request, Faq $faq): JsonResponse
    {
        $validated = $request->validate([
            'pertanyaan' => 'sometimes|string',
            'jawaban'    => 'sometimes|string',
        ]);

        $faq->update($validated);

        return response()->json(['message' => 'FAQ berhasil diperbarui.', 'data' => $faq->fresh()]);
    }

    public function destroy(Faq $faq): JsonResponse
    {
        $faq->delete();

        return response()->json(['message' => 'FAQ berhasil dihapus.']);
    }
}
