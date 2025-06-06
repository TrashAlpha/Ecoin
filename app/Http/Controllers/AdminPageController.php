<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Voucher;
use App\Models\User;
use App\Models\Penukaran_Sampah;
use App\Models\Log_Transaksi;

class AdminPageController extends Controller
{
    public function verifikasi_penukaran()
    {
        return view('verifikasi_penukaran');
    }

    public function manajemen_voucher()
    {
        return view('manajemen_voucher');
    }

    public function manajemen_user()
    {
        return view('manajemen_user');
    }

    public function getAllVouchers()
    {
        try {
            $vouchers = Voucher::all();
            return response()->json([
                'success' => true,
                'data' => $vouchers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data voucher'
            ], 500);
        }
    }

    public function getAllUsers()
    {
        try {
            $users = User::with(['userVouchers.voucher', 'penukaranSampah', 'logTransaksi'])
                         ->orderBy('created_at', 'desc')
                         ->get();
            
            return response()->json([
                'success' => true,
                'data' => $users
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data user'
            ], 500);
        }
    }

    public function getPendingVerifications()
    {
        try {
            $pendingExchanges = Penukaran_Sampah::with(['user'])
                                                ->where('status', 'pending')
                                                ->orderBy('created_at', 'desc')
                                                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $pendingExchanges
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data verifikasi'
            ], 500);
        }
    }

    public function approveExchange(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'catatan_admin' => 'nullable|string|max:500'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $exchange = Penukaran_Sampah::findOrFail($id);
            
            if ($exchange->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Penukaran sudah diverifikasi sebelumnya'
                ], 400);
            }

            $exchange->approve($request->catatan_admin);

            // Create transaction log
            Log_Transaksi::createFromExchange($exchange, 'approved');

            return response()->json([
                'success' => true,
                'message' => 'Penukaran berhasil disetujui',
                'data' => $exchange->load('user')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyetujui penukaran'
            ], 500);
        }
    }

    public function rejectExchange(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'catatan_admin' => 'required|string|max:500'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $exchange = Penukaran_Sampah::findOrFail($id);
            
            if ($exchange->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Penukaran sudah diverifikasi sebelumnya'
                ], 400);
            }

            $exchange->reject($request->catatan_admin);

            // Create transaction log
            Log_Transaksi::createFromExchange($exchange, 'rejected');

            return response()->json([
                'success' => true,
                'message' => 'Penukaran berhasil ditolak',
                'data' => $exchange->load('user')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menolak penukaran'
            ], 500);
        }
    }

    public function createVoucher(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_voucher' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'nilai_koin' => 'required|integer|min:1',
                'image_url' => 'nullable|url',
                'status' => 'required|in:aktif,kadaluarsa'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $voucher = Voucher::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Voucher berhasil dibuat',
                'data' => $voucher
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat voucher'
            ], 500);
        }
    }

    public function updateVoucher(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_voucher' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'nilai_koin' => 'required|integer|min:1',
                'image_url' => 'nullable|url',
                'status' => 'required|in:aktif,kadaluarsa'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $voucher = Voucher::findOrFail($id);
            $voucher->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Voucher berhasil diperbarui',
                'data' => $voucher
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui voucher'
            ], 500);
        }
    }

    public function deleteVoucher($id)
    {
        try {
            $voucher = Voucher::findOrFail($id);
            $voucher->delete();

            return response()->json([
                'success' => true,
                'message' => 'Voucher berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus voucher'
            ], 500);
        }
    }

    public function updateUserStatus(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:active,inactive,banned'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::findOrFail($id);
            $user->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Status user berhasil diperbarui',
                'data' => $user
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status user'
            ], 500);
        }
    }

    public function updateUserCoins(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'saldo_koin' => 'required|integer|min:0'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::findOrFail($id);
            $oldBalance = $user->saldo_koin;
            $user->update(['saldo_koin' => $request->saldo_koin]);

            return response()->json([
                'success' => true,
                'message' => 'Saldo koin user berhasil diperbarui',
                'data' => $user
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui saldo koin user'
            ], 500);
        }
    }
}
