<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function create()
    {
        return view('addresses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_wa' => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        Address::create([
            'user_id' => Auth::id(),
            'no_wa' => $request->no_wa,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('checkout.form')->with('success', 'Alamat berhasil ditambahkan!');
    }
}
