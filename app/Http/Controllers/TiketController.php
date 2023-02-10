<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TiketController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $tiket = "active";
            return view('dataTiket', compact('tiket'));
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function datatiket()
    {
        if (Auth::check()) {
            $data = Tiket::all();
            return $data;
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function addTiket(Request $request)
    {
        if (!Auth::check()) {
            return redirect("login")->withSuccess('You are not allowed to access');
        }

        $kode = $request['kode'];
        $jenis = $request['jenis'];
        $harga = $request['harga'];

        $tiket = new Tiket();
        $tiket->kode = $kode;
        $tiket->harga = $harga;
        $tiket->jenis_kendaraan = $jenis;
        $tiket->save();

        return response()->json(['status' => "success", "message" => "Berhasil Input"]);
    }

    public function edittiket(Request $request)
    {
        $id = $request['id'];
        if (!Auth::check()) {
            return redirect("login")->withSuccess('You are not allowed to access');
        }

        $kode = $request['kode'];
        $jenis = $request['jenis'];
        $harga = $request['harga'];

        $tiket = Tiket::find($id);
        $tiket->kode = $kode;
        $tiket->harga = $harga;
        $tiket->jenis_kendaraan = $jenis;
        $tiket->save();

        return response()->json(['success' => "Berhasil Edit"]);
    }

    public function deletetiket(Request $request)
    {
        $id = $request['id'];
        $tiket = Tiket::find($id);
        $tiket->delete();
        return response()->json(['success' => "Berhasil Delete"]);
    }
}
