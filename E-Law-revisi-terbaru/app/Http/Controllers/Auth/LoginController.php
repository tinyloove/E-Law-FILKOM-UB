<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'role' => ['required', 'in:1,2,3,4'],
        ]);

        // Ambil username dan password
        $credentials = $request->only('username', 'password');

        // Periksa username dan password
        if (Auth::attempt($credentials)) {

            $pengguna = Auth::user();

            // Periksa kesesuaian role
            if ((int) $pengguna->id_role !== (int) $validated['role']) {
                Auth::logout();

                return back()->withErrors([
                    'role' => 'Role yang dipilih tidak sesuai dengan akun Anda.',
                ])->onlyInput('username', 'role');
            }

            // Periksa status akun
            if ($pengguna->status_akun !== 'Aktif') {
                Auth::logout();

                return back()->withErrors([
                    'username' => 'Akun Anda tidak aktif.',
                ])->onlyInput('username', 'role');
            }

            // Perbarui session
            $request->session()->regenerate();

            // Arahkan berdasarkan role
            return match ((int) $pengguna->id_role) {
                1 => redirect('/mahasiswa/dashboard'),
                2 => redirect('/admin/dashboard'),
                3 => redirect('/tim-hukum/dashboard'),
                4 => redirect('/pimpinan/dashboard'),
            };
        }

        // Username atau password salah
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username', 'role');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
