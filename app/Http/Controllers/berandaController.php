<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class berandaController extends Controller
{
    public function pondok()
    {
        return view('beranda.beranda');
    }
}
