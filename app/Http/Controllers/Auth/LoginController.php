<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // ======== Tambahan untuk simpan cart session ke database ========
           // Pindahkan cart dari session ke database
// Sinkron cart dari session ke database
if (session()->has('cart')) {
    foreach (session('cart') as $id => $item) {
        $cart = \App\Models\Cart::firstOrCreate([
            'user_id' => Auth::id(),
            'menu_id' => $id,
        ]);

        $cart->quantity += $item['quantity'];
        $cart->save();
    }
    session()->forget('cart'); // bersihkan session setelah disimpan ke DB
}


            // ================================================================

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang Admin!');
            } else {
                return redirect()->route('menus.index')->with('success', 'Login berhasil!');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah logout.');
    }
    
}
