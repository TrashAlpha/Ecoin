<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Quiz;
use App\Models\UserQuizRewards;
use Auth;
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

    public function submitQuiz(Request $request, $artikelId)
    {
        $user = Auth::user();
        $answers = $request->answer;
        $question = Quiz::where('artikel_id' ,$artikelId)->get();

        // Ambil reward koin dari artikel yang sedang di-quiz-kan
        $artikel = Artikel::findOrFail($artikelId);
        $rewardKoin = $artikel->reward_koin ?? 0; // ambil berdasarkan kolom reward_koin dalam tabel Artikel
        $correctAnswer = 0;

        foreach($question as $q) {
            if (isset($answers[$q->id]) && $answers[$q->id] == $q->jawaban_benar) {
                $correctAnswer++;
            }
        }

        if ($correctAnswer == count($question)) {
            if (!UserQuizRewards::where('user_id', $user->id)
                ->where('artikel_id', $artikelId)->exists()) {
                $user->saldo_koin += $rewardKoin;
                $user->save();
                UserQuizRewards::create([
                    'user_id' => $user->id,
                    'artikel_id' => $artikelId,
                    'rewarded_at' => now()
                ]);
                return response()->json([
                    'success' => true,
                    'message' => "Selamat! Anda dapat {$rewardKoin} koin."
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Koin sudah pernah di-claim sebelumnya'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Jawaban belum semua benar.'
            ]);
        }
    }
}
