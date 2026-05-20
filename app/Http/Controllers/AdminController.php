<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Admin login endpoint.
     *
     * POST /api/admin/login
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if (!$admin || !Hash::check($request->password, $admin->password_hash)) {
            return response()->json([
                'message' => 'Username atau password salah.',
            ], 401);
        }

        return response()->json([
            'message' => 'Login berhasil.',
            'data'    => [
                'id_admin' => $admin->id_admin,
                'username' => $admin->username,
                'email'    => $admin->email,
            ],
        ]);
    }
}
