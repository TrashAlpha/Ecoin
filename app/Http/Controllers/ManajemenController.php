<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManajemenController extends Controller
{
    public function user()
    {
        return view('manajemen_user');
    }

    public function voucher()
    {
        return view('manajemen_voucher');
    }

    public function verifikasiPenukaran()
    {
        return view('verifikasi_penukaran');
    }
}
