<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->email;
        $pwd   = $request->password;
        if (
            Auth::attempt(['email' => $email, 'password' => $pwd, 'role_id' => 2])
        ) {
            $users = DB::table('users')
                ->where('users.email', $email)
                ->first();

            return Response()->json($users);
        } else {
            return Response()->json(["error" => true]);
        }
    }

    public function register(Request $request)
    {
        $nama = $request['nama'];
        $nomor = $request['nomor'];
        $email = $request['email'];
        $password = $request['password'];
        $photo = $request['photo'];

        $check = User::where("email", $email)->count();

        if ($check > 0) {
            return response()->json(['status' => "error", "message" => "Email Sudah Ada"]);
        }

        $namafile = "default.png";
        if ($photo) {
            $extention = $photo->getClientOriginalExtension();
            $tujuan_upload = 'img/user/';
            $namafile = '' . date('Ymdhis') . '.' . $extention;
            $photo->move($tujuan_upload, $namafile);
        }

        $user = new User();
        $user->nama = $nama;
        $user->nomor_hp = $nomor;
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->email = $email;
        $user->photo = $namafile;
        $user->role_id = 2;
        $user->save();

        return response()->json(['status' => "success", 'message' => 'Berhasil Upload', 'data' => $user->id]);
    }

    public function updateprofil(Request $request)
    {
        $id = $request['id'];
        $nama = $request['nama'];
        $nomor = $request['nomor'];
        $email = $request['email'];
        $password = $request['password'];
        $photo = $request['photo'];

        $check = User::where("email", $email)->count();

        if ($check > 0) {
            return response()->json(['status' => "error", "message" => "Email Sudah Ada"]);
        }

        $namafile = "default.png";
        if ($photo) {
            $extention = $photo->getClientOriginalExtension();
            $tujuan_upload = 'img/user/';
            $namafile = '' . date('Ymdhis') . '.' . $extention;
            $photo->move($tujuan_upload, $namafile);
            $user = User::find($id);
            $user->photo = $namafile;
            $user->save();
        }

        $user = User::find($id);
        $user->nama = $nama;
        $user->nomor = $nomor;
        $user->email = $email;
        if($password){
            $user->password = password_hash($password, PASSWORD_DEFAULT);
        }
        $user->save();
    }

    public function updatephoto(Request $request)
    {
        $photo = $request['photo'];
        $id = $request->id;
        $namafile = "";
        if ($photo) {
            $extention = $photo->getClientOriginalExtension();
            $tujuan_upload = 'img/user/';
            $namafile =  $id . date('Ymdhis') . '.' . $extention;
            $photo->move($tujuan_upload, $namafile);
            $user = User::find($id);
            if ($photo) {
                $user->photo = $namafile;
                $user->save();
            }
        }

        return response()->json(['status' => "success", 'message' => 'Berhasil Upload', 'data' => $namafile]);
    }

    public function updatepassword(Request $request)
    {
        $id_user = $request['user_id'];
        $old_password = $request['old_password'];
        $new_password = $request['new_password'];

        $user = User::findOrFail($id_user);

        if (Hash::check($old_password, $user->password)) {
            $user->fill([
                'password' => Hash::make($new_password)
            ])->save();
            return response()->json(['status' => "success", 'message' => "Berhasil ubah password"]);
        } else {
            return response()->json(['status' => "error", 'message' => "Password Lama Salah"]);
        }
    }
}
