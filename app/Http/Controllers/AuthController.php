<?php
namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

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
    
    public function register() {
        $breadcrumb = (object)[
            'title' => 'Registrasi',
            'list' => ['Home', 'Register']
        ];
    
        $activeMenu = 'register';
        $level = LevelModel::all(); 
    
        return view('auth.register', compact('breadcrumb', 'activeMenu', 'level'));
    }

    public function postRegister(Request $request)
{
    $request->validate([
        'username' => 'required|string|min:3|unique:m_user,username',
        'name' => 'required|string|max:100',
        'password' => 'required|string|min:6',
        'level_id' => 'required|integer|exists:m_level,level_id',
    ]);

    UserModel::create([
        'username' => $request->username,
        'nama' => $request->name,
        'password' => $request->password, // sudah auto-hash via casts
        'level_id' => $request->level_id
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Registrasi berhasil!',
        'redirect' => route('login')
    ]);
}

    
}

