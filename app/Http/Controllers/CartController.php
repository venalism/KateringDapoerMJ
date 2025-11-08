<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            // Ambil dari database
            $carts = Cart::with('menu')->where('user_id', Auth::id())->get();
            return view('cart.index', compact('carts'));
        } else {
            // Ambil dari session
            return view('cart.index');
        }
    }

    public function add($id)
    {
        $menu = Menu::findOrFail($id);

        // Kalau user login
        if (Auth::check()) {
            $cartItem = Cart::where('user_id', Auth::id())
                ->where('menu_id', $id)
                ->first();

            if ($cartItem) {
                $cartItem->increment('quantity');
            } else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'menu_id' => $id,
                    'quantity' => 1,
                ]);
            }

        } else {
            // Kalau belum login, simpan di session
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
        }

        return back()->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->where('menu_id', $id)->first();
            if ($cart) {
                if ($request->action === 'increase') {
                    $cart->increment('quantity');
                } elseif ($request->action === 'decrease' && $cart->quantity > 1) {
                    $cart->decrement('quantity');
                }
            }
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                if ($request->action === 'increase') {
                    $cart[$id]['quantity']++;
                } elseif ($request->action === 'decrease' && $cart[$id]['quantity'] > 1) {
                    $cart[$id]['quantity']--;
                }
                session()->put('cart', $cart);
            }
        }

        return redirect()->back()->with('success', 'Jumlah diperbarui.');
    }

    public function remove($id)
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->where('menu_id', $id)->delete();
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
        }

        return back()->with('success', 'Menu dihapus dari keranjang.');
    }
}
