<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json([
                'message' => 'Login berhasil!',
                'user'    => $user
            ], 200);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Email atau password salah.'
            ], 401);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Logout successful!');
    }

    public function register(Request $request)
    {
         // Validasi input
         $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        // Simpan ke database
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'User berhasil didaftarkan!',
            'user'    => $user
        ], 201);
    }

    public function getUser(Request $request)
    {
        $user = Auth::user();
        return response()->json([
            'user'    => $user
        ]);
    }
}
