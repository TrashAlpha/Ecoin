<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sampah;
use Illuminate\Support\Facades\Validator;

class SampahController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Sampah::query();

            // Filter by type if provided
            if ($request->has('tipe') && $request->tipe !== '') {
                $query->where('tipe_sampah', $request->tipe);
            }

            // Filter by status if provided
            if ($request->has('status') && $request->status !== '') {
                $query->where('status', $request->status);
            } else {
                // Default to active only
                $query->where('status', 'active');
            }

            $sampah = $query->orderBy('nama_sampah')->get();

            return response()->json([
                'success' => true,
                'data' => $sampah
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data sampah'
            ], 500);
        }
    }

    public function getByType($type)
    {
        try {
            $sampah = Sampah::active()->byTipe($type)->get();

            return response()->json([
                'success' => true,
                'data' => $sampah
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data sampah'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_sampah' => 'required|string|max:255',
                'tipe_sampah' => 'required|in:organik,anorganik,medis',
                'nilai_koin_per_kg' => 'required|integer|min:1',
                'deskripsi' => 'nullable|string',
                'status' => 'required|in:active,inactive'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $sampah = Sampah::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Data sampah berhasil ditambahkan',
                'data' => $sampah
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data sampah'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $sampah = Sampah::find($id);

            if (!$sampah) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data sampah tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $sampah
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data sampah'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $sampah = Sampah::find($id);

            if (!$sampah) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data sampah tidak ditemukan'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'nama_sampah' => 'required|string|max:255',
                'tipe_sampah' => 'required|in:organik,anorganik,medis',
                'nilai_koin_per_kg' => 'required|integer|min:1',
                'deskripsi' => 'nullable|string',
                'status' => 'required|in:active,inactive'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $sampah->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Data sampah berhasil diperbarui',
                'data' => $sampah
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data sampah'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $sampah = Sampah::find($id);

            if (!$sampah) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data sampah tidak ditemukan'
                ], 404);
            }

            $sampah->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data sampah berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data sampah'
            ], 500);
        }
    }
} 