<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profil');
    }

    public function daftartransaksi()
    {
        return view('daftartransaksi');
    }
}


