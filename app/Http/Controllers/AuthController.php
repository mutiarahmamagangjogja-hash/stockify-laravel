<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
            ],
        ], [
            'email.required' =>
                'Email wajib diisi.',

            'email.email' =>
                'Format email tidak valid.',

            'password.required' =>
                'Password wajib diisi.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | LOGIN
        |--------------------------------------------------------------------------
        */

        if (!Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'status' => true,
        ])) {

            return back()
                ->withErrors([
                    'email' =>
                        'Email atau password salah, atau akun tidak aktif.',
                ])
                ->withInput(
                    $request->only('email')
                );
        }

        /*
        |--------------------------------------------------------------------------
        | REGENERATE SESSION
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();

        /*
        |--------------------------------------------------------------------------
        | REDIRECT BERDASARKAN ROLE
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();

        switch ($user->role) {

            case 'admin':

                return redirect()
                    ->route('dashboard');

            case 'manager_gudang':

                return redirect()
                    ->route('manager-gudang.dashboard');

            case 'staff_gudang':

                return redirect()
                    ->route('staff-gudang.dashboard');

            default:

                Auth::logout();

                return back()
                    ->withErrors([
                        'email' =>
                            'Role pengguna tidak dikenali.',
                    ]);
        }
    }

    /**
     * Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login');
    }
}