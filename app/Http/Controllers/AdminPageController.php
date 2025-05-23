<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
