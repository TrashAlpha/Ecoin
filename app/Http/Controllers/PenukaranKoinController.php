<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\User;
use App\Models\Penukaran_Koin;
use App\Models\Log_Transaksi;
use App\Models\UserVoucher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PenukaranKoinController extends Controller
{
    // Get available vouchers
    public function getAvailableVouchers()
    {
        try {
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

    // Process voucher exchange
    public function exchangeVoucher(Request $request)
    {
        $user = Auth::user();
        Log::info('User mencoba tukar voucher', [
            'user_id' => $user->id,
            'user_koin' => $user->saldo_koin,
            'voucher_id' => $request->voucher_id
        ]);
        
        $request->validate([
            'voucher_id' => 'required|exists:vouchers,id',
        ]);

        $user = Auth::user();
        $voucher = Voucher::findOrFail($request->voucher_id);

        // Check user balance
        if ($user->saldo_koin < $voucher->nilai_koin) {
            return response()->json([
                'success' => false,
                'message' => 'Saldo koin tidak mencukupi untuk menukar voucher ini.'
            ], 400);
        }

        // Return confirmation data (frontend will handle the actual confirmation)
        return response()->json([
            'success' => true,
            'confirmation' => [
                'message' => "Apakah Anda yakin untuk menukar {$voucher->nilai_koin} koin menjadi {$voucher->nama_voucher}?",
                'voucher_id' => $voucher->id,
                'voucher_name' => $voucher->nama_voucher,
                'koin_cost' => $voucher->nilai_koin,
            ]
        ]);
    }

    // Confirm and process the voucher exchange
    public function confirmExchange(Request $request)
    {
        $request->validate([
            'voucher_id' => 'required|exists:vouchers,id',
        ]);

        $user = Auth::user();
        $voucher = Voucher::findOrFail($request->voucher_id);

        // Double check user balance (in case it changed since confirmation)
        if ($user->saldo_koin < $voucher->nilai_koin) {
            return response()->json([
                'success' => false,
                'message' => 'Saldo koin tidak mencukupi untuk menukar voucher ini.'
            ], 400);
        }

        // Start transaction
        \DB::transaction(function () use ($user, $voucher) {
            // Deduct user's coins
            $user->saldo_koin -= $voucher->nilai_koin;
            $user->save();

            // Create penukaran koin record
            $penukaran = Penukaran_Koin::create([
                'user_id' => $user->id,
                'tipe_penukaran' => 'tukar_voucher',
                'nilai_koin' => $voucher->nilai_koin,
                'tanggal_transaksi' => now(),
                'voucher_id' => $voucher->id
            ]);

            // Create user voucher
            $userVoucher = UserVoucher::create([
                'user_id' => $user->id,
                'voucher_id' => $voucher->id,
                'tanggal_diperoleh' => now(),
                'status' => 'active'
            ]);

            // Log the transaction
            Log_Transaksi::createLog(
                $user->id,
                'tukar_voucher',
                -$voucher->nilai_koin, // Negative because it's a deduction
                $penukaran
            );
        });

        return response()->json([
            'success' => true,
            'message' => 'Penukaran voucher berhasil!',
            'updated_coin_balance' => $user->fresh()->koin
        ]);
    }
}