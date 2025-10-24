<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if ($admin && $credentials['password'] === $admin->password) {
            Auth::login($admin);
            return redirect()->intended('/'); // Rute pengalihan setelah login berhasil
        }

        return back()->withErrors([
            'username' => 'Login gagal. Periksa username dan password Anda.',
        ]);
    }
}
