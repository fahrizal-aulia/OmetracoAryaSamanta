<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.loginuser');
    }

    public function showAdminLogin() {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required'
        ]);

        // Mapping nama role ke role_id
        $roleMapping = [
            'project control' => 1,
            'purchasing' => 2,
            'owner' => 3
        ];

        if (!array_key_exists($request->role, $roleMapping)) {
            return back()->withErrors(['Role tidak valid']);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['Email atau password salah']);
        }

        if ($user->role_id !== $roleMapping[$request->role]) {
            return back()->withErrors(['Role tidak sesuai dengan akun']);
        }

        Auth::login($user);

        // Redirect berdasarkan role_id
        switch ($user->role_id) {
            case 1:
                return redirect('/project-control/dashboard');
            case 2:
                return redirect('/purchasing/dashboard');
            case 3:
                return redirect('owner/dashboard');
            default:
                return redirect('/dashboard');
        }
    }

    public function adminLogin(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role_id !== 4) {
                Auth::logout();
                return back()->withErrors(['email' => 'Anda tidak memiliki akses admin.']);
            }

            return redirect('/dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login.form')->with('success', 'Registrasi berhasil!');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function adminLogout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}
