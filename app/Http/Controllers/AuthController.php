<?php
namespace App\Http\Controllers; use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
        public function login()
    {
        if(Auth::check()){ 
    }
    return view('auth.login');
}

public function postLogin(Request $request)
{
    $credentials = $request->only('username', 'password');

    if (Auth::attempt($credentials)) {
        return response()->json([
            'status' => true,
            'message' => 'Login berhasil!',
            'redirect' => url('/')
        ]);
    }

    return response()->json([
        'status' => false,
        'message' => 'Username atau password salah!',
        'msgField' => [
            'username' => ['Username salah atau tidak ditemukan'],
            'password' => ['Password salah']
        ]
    ], 422);
}

public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken(); return redirect('login');
    }
    
}
