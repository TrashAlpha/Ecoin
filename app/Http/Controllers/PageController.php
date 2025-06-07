<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class PageController extends Controller
{
    public function index()
    {
        return redirect('/beranda');
    }

    public function home()
    {
        return view('beranda');
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function penukaran1()
    {
        return view('penukarans1');
    }

    public function penukaran2()
    {
        return view('penukarans2');
    }

    public function penukaran3()
    {
        return view('penukarans3');
    }

    public function penukaran3_2()
    {
        return view('penukarans3_2');
    }

    public function penukaran_koin()
    {
        return view('penukarankoin');
    }

    public function jelajah()
    {
        return view('jelajah');
    }

    public function tentang()
    {
        return view('tentang');
    }

    public function profil()
    {
        return view('profil');
    }

    public function daftartransaksi()
    {
        return view('daftartransaksi');
    }

    public function verifikasi_penukaran()
    {
        return view('verifikasipenukaran');
    }

    public function voucheranda()
    {
        return view('voucher_anda');
    }

    public function artikel()
    {
        return view('artikel');
    }
    public function getProduk()
    {
        try {
            $produk = Produk::where('status', 'active')->get();
            return response()->json([
                'success' => true,
                'data' => $produk
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data produk'
            ], 500);
        }
    }
}
