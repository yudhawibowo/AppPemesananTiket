<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect("dashboard");
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $email = $request->email;
        $pwd   = $request->password;

        $remember = true;
        if (
            Auth::attempt(['email' => $email, 'password' => $pwd, 'role_id' => 1], $remember)
        ) {
            return redirect()->intended('dashboard')
                ->withSuccess('Signed in');
        }

        return redirect("login")->withErrors('Akun Tidak Ditemukan');
    }

    public function dashboard()
    {
        if (Auth::check()) {
            $home = "active";
            return view('dashboard', compact('home'));
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function profil()
    {
        if (Auth::check()) {
            $profil = "active";
            return view('profil', compact('profil'));
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function dataprofil(Request $request)
    {
        $id = Auth::id();
        if (Auth::check()) {
            $user = User::where('id', $id)->get()->toArray();
            return $user;
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function updatepassword(Request $request)
    {
        $old_password = $request['old_password'];
        $new_password = $request['new_password'];

        $user = User::findOrFail(Auth::id());

        if (Hash::check($old_password, $user->password)) {
            $user->fill([
                'password' => Hash::make($new_password)
            ])->save();
            return response()->json(['status' => "success", 'message' => "Berhasil ubah password"]);
        } else {
            return response()->json(['status' => "error", 'message' => "Password Lama Salah"]);
        }
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
}
