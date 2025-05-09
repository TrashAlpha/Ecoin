<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    public function verifikasi_penukaran()
    {
        return view('verifikasi_penukaran');
    }

    public function kelola_voucher()
    {
        return view('kelola_voucher');
    }

    public function kelola_user()
    {
        return view('kelola_user');
    }
}
