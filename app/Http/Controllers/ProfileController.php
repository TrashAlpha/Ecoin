<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Log_Transaksi;
use App\Models\User;
use App\Models\Voucher;
use App\Models\UserVoucher;

class ProfileController extends Controller
{
    public function getDaftarTransaksi()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $transaksi = Log_Transaksi::byUser($user->id)
            ->latest()
            ->get([
                'jenis_transaksi',
                'tanggal_transaksi',
                'jumlah_koin',
            ]);

        return response()->json($transaksi);
    }

    public function getUserVouchers()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $vouchers = UserVoucher::with(['voucher' => function($query) {
                $query->select('id', 'nama_voucher', 'nilai_koin', 'deskripsi');
            }])
            ->byUser($user->id)
            ->latest('tanggal_diperoleh')
            ->get([
                'id',
                'voucher_id',
                // 'kode_voucher', // Pastikan kolom ini ada di tabel
                'tanggal_diperoleh',
                'status'
            ]);

        $formattedVouchers = $vouchers->map(function ($userVoucher) {
            return [
                'nama_voucher' => $userVoucher->voucher->nama_voucher ?? 'Voucher Tidak Diketahui',
                'nilai_voucher' => $userVoucher->voucher->nilai_koin ?? 0,
                'deskripsi' => $userVoucher->voucher->deskripsi ?? '',
                'tanggal_diperoleh' => $userVoucher->tanggal_diperoleh->format('d F Y'),
                // 'kode_voucher' => $userVoucher->kode_voucher ?? '-',
                'status' => $userVoucher->status,
            ];
        });

        return response()->json($formattedVouchers);
    }
}