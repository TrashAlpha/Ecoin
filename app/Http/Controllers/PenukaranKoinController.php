<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;

class PenukaranKoinController extends Controller
{
    // Mendapatkan saldo pengguna yang sedang login
    public function getSaldo()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        return response()->json(['saldo' => $user->saldo_koin], 200);
    }

    // Mendapatkan daftar voucher yang tersedia
    // public function getAvailableVouchers()
    // {
    //     $vouchers = Voucher::all();

    //     return response()->json(['vouchers' => $vouchers], 200);
    // }

    public function getAvailableVouchers()
    {
        try {
            // Ambil hanya voucher yang statusnya aktif
            $vouchers = Voucher::where('status', 'aktif')
                ->select(['id', 'nama_voucher', 'nilai_koin', 'deskripsi', 'image_url'])
                ->get()
                ->toArray();

            return response()->json([
                'success' => true,
                'vouchers' => $vouchers
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data voucher'
            ], 500);
        }
    }
}
