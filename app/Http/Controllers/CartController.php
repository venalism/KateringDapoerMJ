<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add($id)
    {
        $menu = Menu::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $menu->name,
                "price" => $menu->price,
                "photo" => $menu->photos->first(),
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    public function index()
    {
        return view('cart.index');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Menu dihapus dari keranjang.');
    }
    public function update(Request $request, $id)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        if ($request->action === 'increase') {
            $cart[$id]['quantity']++;
        } elseif ($request->action === 'decrease' && $cart[$id]['quantity'] > 1) {
            $cart[$id]['quantity']--;
        }

        session()->put('cart', $cart);
    }

    return redirect()->back()->with('success', 'Jumlah diperbarui.');
}


}
