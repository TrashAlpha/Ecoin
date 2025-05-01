<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenukaranController extends Controller
{
    public function index()
    {
        return view('home');
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
}
