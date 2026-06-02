<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9\s]).+$/',
            ],
        ], [
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.max' => 'Password maksimal harus 20 karakter.',
            'password.regex' => 'Password harus mengandung minimal 1 huruf kapital, 1 huruf kecil, 1 angka, dan 1 simbol.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

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
