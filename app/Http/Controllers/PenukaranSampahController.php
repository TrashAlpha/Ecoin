<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Penukaran_Sampah;
use App\Models\Sampah;
use App\Models\Log_Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class PenukaranSampahController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'detail_sampah' => 'required|array|min:1',
                'detail_sampah.*.nama_sampah' => 'required|exists:sampah,nama_sampah',
                'detail_sampah.*.jumlah' => 'required|numeric|min:0.1',
                'tanggal_penukaran' => 'required|date|after_or_equal:today',
                'waktu_penukaran' => 'required|date_format:H:i',
                'lokasi_penukaran' => 'required|string|max:255',
                'alamat_detail' => 'nullable|string|max:500',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180'
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
                $sampah = Sampah::where('nama_sampah', $item['nama_sampah'])->first();
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
                    'berat' => $item['jumlah'],
                    'nilai_koin_per_kg' => $sampah->nilai_koin_per_kg,
                    'total_koin' => $koinItem
                ];
            }

            // Create exchange record
            $exchange = Penukaran_Sampah::create([
                'user_id' => $request->user_id,
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

            return response()->json([
                'success' => true,
                'message' => 'Penukaran sampah berhasil diajukan dan menunggu verifikasi admin',
                'data' => $exchange
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengajukan penukaran sampah',
                'errors' => $e->getMessage()
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

    public function getCalculatedCoin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'detail_sampah' => 'required|array|min:1',
                'detail_sampah.*.nama_sampah' => 'required|exists:sampah,nama_sampah',
                'detail_sampah.*.jumlah' => 'required|numeric|min:0.1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $totalKoin = 0;

            foreach ($request->detail_sampah as $item) {
                $sampah = Sampah::where('nama_sampah', $item['nama_sampah'])->first();
                if (!$sampah || $sampah->status !== 'active') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Jenis sampah tidak valid atau tidak aktif'
                    ], 400);
                }

                $koinItem = $sampah->nilai_koin_per_kg * $item['jumlah'];
                $totalKoin += $koinItem;
            }

            return response()->json([
                'success' => true,
                'data' => ['total_koin' => $totalKoin]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghitung koin'
            ], 500);
        }
    }

    public function index() {
        try {
            // 1. Lakukan Eager Loading untuk mengambil data user bersamaan dengan data penukaran
            $exchanges = Penukaran_Sampah::with('user:id,name,email') // Hanya ambil kolom id, name, dan email dari tabel user
                                    ->orderBy('created_at', 'desc')
                                    ->get();

            // 2. Iterasi setiap data penukaran untuk menambahkan total berat dan merapikan data user
            $exchanges->each(function($exchange) {
            // Hitung total berat/jumlah dari array 'detail_sampah'
            // Menggunakan '??' untuk menangani jika key 'berat' atau 'jumlah' tidak ada
            $totalWeight = collect($exchange->detail_sampah)->sum(function($detail) {
                return $detail['berat'] ?? $detail['jumlah'] ?? 0;
            });

            // Tambahkan field baru 'total_berat_sampah' ke dalam objek exchange
            $exchange->berat = $totalWeight;
            
            // Masukkan nama dan email user ke dalam root object untuk kemudahan akses
            if ($exchange->user) {
                $exchange->nama_pengguna = $exchange->user->name;
                $exchange->email_pengguna = $exchange->user->email;
            }

            // Hapus relasi user yang sudah tidak diperlukan agar JSON lebih rapi
            unset($exchange->user);
        });

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

    public function updateStatus(Request $request, Penukaran_Sampah $penukaran)
    {
        // 1. Validasi request yang masuk
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:approved,rejected', // Hanya menerima 'approved' atau 'rejected'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422); // 422 Unprocessable Entity
        }

        try {
            // 2. Update status pada model yang ditemukan via Route-Model Binding
            $penukaran->status = $request->status;
            $penukaran->save();

            if ($penukaran->status === 'approved') {
                $user = User::find($penukaran->user_id);

                if ($user) {
                    $user->saldo_koin += $penukaran->total_koin; // Tambahkan koin
                    $user->save(); // Simpan perubahan pada user
                } else {
                    // Opsional: Log error jika user tidak ditemukan
                    Log::error("User with ID {$penukaran->user_id} not found for coin update after waste exchange approval.");
                }
            }

            // 3. Kirim respons sukses dalam format JSON
            return response()->json([
                'success' => true,
                'message' => 'Status penukaran berhasil diperbarui.',
                'data' => $penukaran, // Mengirim kembali data yang sudah diupdate
            ]);

        } catch (\Exception $e) {
            // Tangani jika ada error lain (misal: error database)
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage(),
            ], 500); // 500 Internal Server Error
        }
    }

    public function getApprovedPenukaranByUserId($userId)
    {
        try {
            // Mengambil data penukaran sampah dari database
            // dengan kondisi user_id dan status 'approved'
            $penukaran = Penukaran_Sampah::where('user_id', $userId)
                                        ->where('status', 'approved')
                                        ->get();

            // Memeriksa apakah ada data penukaran yang ditemukan
            if ($penukaran->isEmpty()) {
                return response()->json([
                    'message' => 'Tidak ada data penukaran sampah yang ditemukan untuk user_id ini dengan status approved.'
                ], 404); // Mengembalikan status 404 jika tidak ditemukan
            }

            // Mengembalikan data penukaran dalam format JSON
            return response()->json([
                'message' => 'Data penukaran sampah berhasil diambil.',
                'data' => $penukaran
            ], 200); // Mengembalikan status 200 jika berhasil
        } catch (\Exception $e) {
            // Menangani error jika terjadi masalah saat mengambil data
            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data penukaran sampah.',
                'error' => $e->getMessage()
            ], 500); // Mengembalikan status 500 untuk error server
        }
    }
} 