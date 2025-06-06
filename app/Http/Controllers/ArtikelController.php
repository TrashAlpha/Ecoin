<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index(Request $request)
    {
        try {
            $artikel = Artikel::all();
            return response()->json([
                'success' => true,
                'data' => $artikel
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data artikel'
            ], 500);
        }
    }

    public function getArtikelId(Request $request, $id)
    {
        try {
            $artikel = Artikel::with('quiz')->find($id);

            if(!$artikel){
                return response()->json([
                    'success' => false,
                    'message' => 'Artikel dengan id tersebut tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $artikel
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data artikel dengan id tersebut'
            ]);
        }
    }
}
