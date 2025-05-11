<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);
        $field = filter_var($data['login'], FILTER_VALIDATE_EMAIL)? 'email': 'username';
        if (Auth::attempt([$field => $data['login'], 'password' => $data['password']], $request->filled('remember'))) {
            $dataUser = User::where('email', $data['login'])
            ->orWhere('username', $data['login'])
            ->first();
            $request->session()->regenerate();
            if ($dataUser->role == 'admin') {
                // dd($dataUser);
                // return redirect()->intended('dashboard');
                return redirect()->route('admin.urls.index');
            } elseif ($dataUser->role == 'user') {
                // return redirect()->intended('dashboard');
                return redirect()->route('data.index');
            }
        }
        return back()
            ->withErrors(['login' => 'ข้อมูลผู้ใช้หรือรหัสผ่านไม่ถูกต้อง'])
            ->onlyInput('login');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required',
            'email'    => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return redirect()->intended('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

}
