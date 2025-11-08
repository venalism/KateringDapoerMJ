<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $address = $user->address;
        $orders = $user->orders;

        return view('profile.index', compact('user', 'address', 'orders'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
        ]);

        $user = Auth::user();
        $user->update($request->only('name', 'email'));

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui!');
    }

    public function editAddress()
    {
        $address = Auth::user()->address;
        return view('profile.address', compact('address'));
    }

    public function updateAddress(Request $request)
    {
        $request->validate([
            'no_wa' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
        ]);

        Address::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'no_wa' => $request->no_wa,
                'alamat' => $request->alamat
            ]
        );

        return redirect()->route('profile.index')->with('success', 'Alamat berhasil diperbarui!');
    }
}
