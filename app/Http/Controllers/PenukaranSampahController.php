<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Penukaran_Sampah;
use App\Models\Sampah;
use App\Models\Log_Transaksi;

class PenukaranSampahController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'detail_sampah' => 'required|array|min:1',
                'detail_sampah.*.sampah_id' => 'required|exists:sampah,id',
                'detail_sampah.*.jumlah' => 'required|numeric|min:0.1',
                'tanggal_penukaran' => 'required|date|after_or_equal:today',
                'waktu_penukaran' => 'required|date_format:H:i',
                'lokasi_penukaran' => 'required|string|max:255',
                'alamat_detail' => 'required|string|max:500',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180',
                'bukti_transaksi' => 'required|array|min:1',
                'bukti_transaksi.*' => 'required|string' // Base64 encoded images
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Calculate total coins
            $totalKoin = 0;
            $detailSampah = [];

            foreach ($request->detail_sampah as $item) {
                $sampah = Sampah::find($item['sampah_id']);
                if (!$sampah || $sampah->status !== 'active') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Jenis sampah tidak valid atau tidak aktif'
                    ], 400);
                }

                $koinItem = $sampah->nilai_koin_per_kg * $item['jumlah'];
                $totalKoin += $koinItem;

                $detailSampah[] = [
                    'sampah_id' => $sampah->id,
                    'nama_sampah' => $sampah->nama_sampah,
                    'jenis' => $sampah->jenis,
                    'jumlah' => $item['jumlah'],
                    'nilai_koin_per_kg' => $sampah->nilai_koin_per_kg,
                    'total_koin' => $koinItem
                ];
            }

            // Create exchange record
            $exchange = Penukaran_Sampah::create([
                'user_id' => Auth::id(),
                'detail_sampah' => $detailSampah,
                'tanggal_penukaran' => $request->tanggal_penukaran,
                'waktu_penukaran' => $request->waktu_penukaran,
                'lokasi_penukaran' => $request->lokasi_penukaran,
                'alamat_detail' => $request->alamat_detail,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'bukti_transaksi' => $request->bukti_transaksi,
                'total_koin' => $totalKoin,
                'status' => 'pending'
            ]);

            // Create transaction log
            Log_Transaksi::createFromExchange($exchange, 'pending');

            return response()->json([
                'success' => true,
                'message' => 'Penukaran sampah berhasil diajukan dan menunggu verifikasi admin',
                'data' => $exchange
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengajukan penukaran sampah'
            ], 500);
        }
    }

    public function getUserExchanges()
    {
        try {
            $exchanges = Penukaran_Sampah::where('user_id', Auth::id())
                                        ->orderBy('created_at', 'desc')
                                        ->get();

            return response()->json([
                'success' => true,
                'data' => $exchanges
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data penukaran'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $exchange = Penukaran_Sampah::where('user_id', Auth::id())
                                       ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $exchange
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data penukaran tidak ditemukan'
            ], 404);
        }
    }

    public function cancel($id)
    {
        try {
            $exchange = Penukaran_Sampah::where('user_id', Auth::id())
                                       ->where('status', 'pending')
                                       ->findOrFail($id);

            $exchange->update(['status' => 'cancelled']);

            // Create transaction log
            Log_Transaksi::createFromExchange($exchange, 'cancelled');

            return response()->json([
                'success' => true,
                'message' => 'Penukaran berhasil dibatalkan',
                'data' => $exchange
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membatalkan penukaran'
            ], 500);
        }
    }
} 