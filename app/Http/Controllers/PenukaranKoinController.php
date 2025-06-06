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
    
    // Get available transfer methods
    public function getTransferMethods()
    {
        try {
            $methods = [
                ['id' => 'bni', 'name' => 'Bank BNI', 'admin_fee' => 2000],
                ['id' => 'bri', 'name' => 'Bank BRI', 'admin_fee' => 2500],
                ['id' => 'bca', 'name' => 'Bank BCA', 'admin_fee' => 2000],
                ['id' => 'mandiri', 'name' => 'Bank Mandiri', 'admin_fee' => 1500],
                ['id' => 'bsi', 'name' => 'Bank BSI', 'admin_fee' => 3000],
                ['id' => 'btn', 'name' => 'Bank BTN', 'admin_fee' => 3500],
                ['id' => 'gopay', 'name' => 'GoPay', 'admin_fee' => 1000],
                ['id' => 'dana', 'name' => 'DANA', 'admin_fee' => 500],
            ];

            return response()->json([
                'success' => true,
                'methods' => $methods
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil metode transfer'
            ], 500);
        }
    }

    // Process coin to money exchange
    public function exchangeToMoney(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'transfer_method' => 'required|string',
            'coin_amount' => 'required|integer|min:1',
        ]);

        $coinAmount = $request->coin_amount;
        $transferMethod = $request->transfer_method;

        // Check user balance
        if ($user->saldo_koin < $coinAmount) {
            return response()->json([
                'success' => false,
                'message' => 'Saldo koin tidak mencukupi untuk penukaran ini.'
            ], 400);
        }

        // Get transfer method details (dummy data)
        $methodDetails = $this->getMethodDetails($transferMethod);
        if (!$methodDetails) {
            return response()->json([
                'success' => false,
                'message' => 'Metode transfer tidak valid.'
            ], 400);
        }

        // Calculate money amount (1 koin = 1000 rupiah)
        $moneyAmount = ($coinAmount * 1000) - $methodDetails['admin_fee'];

        // Return confirmation data
        return response()->json([
            'success' => true,
            'confirmation' => [
                'message' => "Apakah Anda yakin untuk menukar {$coinAmount} koin menjadi Rp " . number_format($moneyAmount, 0, ',', '.') . "?",
                'transfer_method' => $methodDetails['name'],
                'coin_amount' => $coinAmount,
                'money_amount' => $moneyAmount,
                'admin_fee' => $methodDetails['admin_fee'],
            ]
        ]);
    }

    // Confirm and process the money exchange
    public function confirmMoneyExchange(Request $request)
    {
        $request->validate([
            'transfer_method' => 'required|string',
            'coin_amount' => 'required|integer|min:1',
            'account_number' => 'required|string',
            'password' => 'required|string', // Dummy password validation
        ]);

        $user = Auth::user();
        $coinAmount = $request->coin_amount;
        $transferMethod = $request->transfer_method;
        $accountNumber = $request->account_number;
        $password = $request->password;

        // Dummy password validation (in real app, use proper auth)
        if ($password !== 'password123') {
            return response()->json([
                'success' => false,
                'message' => 'Password salah. Transaksi dibatalkan.'
            ], 401);
        }

        // Double check user balance
        if ($user->saldo_koin < $coinAmount) {
            return response()->json([
                'success' => false,
                'message' => 'Saldo koin tidak mencukupi untuk penukaran ini.'
            ], 400);
        }

        // Get transfer method details
        $methodDetails = $this->getMethodDetails($transferMethod);
        if (!$methodDetails) {
            return response()->json([
                'success' => false,
                'message' => 'Metode transfer tidak valid.'
            ], 400);
        }

        // Calculate money amount
        $moneyAmount = ($coinAmount * 1000) - $methodDetails['admin_fee'];

        // Start transaction
        \DB::transaction(function () use ($user, $coinAmount, $moneyAmount, $transferMethod, $accountNumber, $methodDetails) {
            // Deduct user's coins
            $user->saldo_koin -= $coinAmount;
            $user->save();

            // Create penukaran koin record
            $penukaran = Penukaran_Koin::create([
                'user_id' => $user->id,
                'tipe_penukaran' => 'tukar_rupiah',
                'nilai_koin' => $coinAmount,
                'nilai_rupiah' => $moneyAmount,
                'tanggal_transaksi' => now(),
                'metode_transfer' => $transferMethod,
                'nomor_rekening' => $accountNumber
            ]);

            // Log the transaction
            Log_Transaksi::createLog(
                $user->id,
                'tukar_rupiah',
                -$coinAmount, // Negative because it's a deduction
                $penukaran
            );
        });

        return response()->json([
            'success' => true,
            'message' => 'Penukaran koin ke rupiah berhasil!',
            'data' => [
                'received_amount' => $moneyAmount,
                'formatted_amount' => 'Rp ' . number_format($moneyAmount, 0, ',', '.'),
                'admin_fee' => $methodDetails['admin_fee'],
                'updated_coin_balance' => $user->fresh()->saldo_koin
            ]
        ]);
    }

    // Helper function to get transfer method details
    private function getMethodDetails($methodId)
    {
        $methods = [
            ['id' => 'bni', 'name' => 'Bank BNI', 'admin_fee' => 2000],
            ['id' => 'bri', 'name' => 'Bank BRI', 'admin_fee' => 2500],
            ['id' => 'bca', 'name' => 'Bank BCA', 'admin_fee' => 2000],
            ['id' => 'mandiri', 'name' => 'Bank Mandiri', 'admin_fee' => 1500],
            ['id' => 'bsi', 'name' => 'Bank BSI', 'admin_fee' => 3000],
            ['id' => 'btn', 'name' => 'Bank BTN', 'admin_fee' => 3500],
            ['id' => 'gopay', 'name' => 'GoPay', 'admin_fee' => 1000],
            ['id' => 'dana', 'name' => 'DANA', 'admin_fee' => 500],
        ];

        foreach ($methods as $method) {
            if ($method['id'] === $methodId) {
                return $method;
            }
        }

        return null;
    }
}