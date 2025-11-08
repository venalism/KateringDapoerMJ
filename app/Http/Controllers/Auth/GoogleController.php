<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use stateless;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        // GANTI BARIS INI
        // $googleUser = Socialite::driver('google')->user();

        // MENJADI INI:
        $googleUser = Socialite::driver('google')->stateless()->user(); // <-- Tambahkan stateless()

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? $googleUser->getEmail(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(Str::random(16)),
                'role' => 'customer',
            ]);
        }

        Auth::login($user, true);

        return redirect()->intended('/');
    }
}
