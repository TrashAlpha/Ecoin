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
    public function getAvailableVouchers()
    {
        $vouchers = Voucher::all();

        return response()->json(['vouchers' => $vouchers], 200);
    }
}
