<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\User;

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
    public function getAllVouchers()
    {
        return response()->json(Voucher::all());
    }
    public function getAllUsers()
    {
        return response()->json(User::all());
    }
}
