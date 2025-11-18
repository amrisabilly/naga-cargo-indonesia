<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AuthenticatedController extends Controller
{
    public function login()
    {
        return view('auth.login.index');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('username', $credentials['username'])->first();

        // Gunakan Hash::check untuk membandingkan password hash
        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            Auth::guard('web')->login($admin);
            return redirect()->route('dashboard.index');
        }

        return back()->withErrors([
            'username' => 'Login gagal. Periksa username dan password Anda.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login');
    }
}
