<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        if (Auth::check()) {
            $user = "active";
            return view('dataUser', compact('user'));
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function detailuser()
    {
        if (Auth::check()) {
            $user = "active";
            $datauser = "active";
            return view('detailUser', compact('user', 'datauser'));
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function addUser(Request $request)
    {
        if (!Auth::check()) {
            return redirect("login")->withSuccess('You are not allowed to access');
        }
        $email = $request['email'];
        $nomor = $request['nomor'];

        $check = User::where("email", $email)->count();

        if ($check > 0) {
            return response()->json(['status' => "error", "message" => "Email Sudah Ada"]);
        }

        $nama = $request['nama'];
        $nomor = $request['nomor'];
        $email = $request['email'];
        $password = $request['password'];
        $image = $request->file('gambar');
        $namafile = "default.png";

        if ($image) {
            $extention = $image->getClientOriginalExtension();
            $tujuan_upload = 'img/user/';
            $namafile = '' . date('Ymdhis') . '.' . $extention;
            $request->file('gambar')->move($tujuan_upload, $namafile);
        }

        $user = new User();
        $user->nama = $nama;
        $user->nomor_hp = $nomor;
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->email = $email;
        $user->role_id = 2;
        $user->photo = $namafile;
        $user->save();

        return response()->json(['status' => "success", "message" => "Berhasil Input"]);
    }

    public function edituser(Request $request)
    {
        $id = $request['id'];
        $nama = $request['nama'];
        $nomor = $request['nomor'];
        $image = $request->file('gambar');
        $namafile = "";
        if ($image) {
            $extention = $image->getClientOriginalExtension();
            $tujuan_upload = 'img/user/';
            $namafile = '' . date('Ymdhis') . '.' . $extention;
            $request->file('gambar')->move($tujuan_upload, $namafile);
        }

        $user = User::find($id);
        $user->nama = $nama;
        $user->nomor_hp = $nomor;
        if($image){
            $user->photo = $namafile;
        }
        $user->save();

        return response()->json(['success' => "Berhasil Edit"]);
    }

    public function deleteuser(Request $request)
    {
        $id = $request['id'];
        $user = User::find($id);
        $user->delete();
        return response()->json(['success' => "Berhasil Delete"]);
    }
    
    public function datauser()
    {
        if (Auth::check()) {
            $user = User::where("role_id", "!=", 1)->get()->toArray();
            return $user;
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function datadetailuser(Request $request)
    {
        $id = $request['id'];
        if (Auth::check()) {
            $user = User::where('id', $id)->get()->toArray();
            return $user;
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }
}
