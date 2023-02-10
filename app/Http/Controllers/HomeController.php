<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function data()
    {
        $tiket = DB::table("tiket")->count();
        $kendaraan = DB::table("kendaraan")->count();
        $pemesanan = DB::table("pemesanan")->count();

        $data = [
            'tiket' => $tiket,
            'kendaraan' => $kendaraan,
            'pemesanan' => $pemesanan,
        ];

        return response()->json($data);
    }
}
